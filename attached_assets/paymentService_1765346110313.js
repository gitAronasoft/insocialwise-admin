const stripeKey = process.env.STRIPE_SECRET_KEY;
const stripe = stripeKey ? require("stripe")(stripeKey) : null;
const { v4: uuidv4 } = require("uuid");
const bcrypt = require("bcryptjs");
const crypto = require("crypto");

const User = require("../models/mysql/User");
const Subscriptions = require("../models/mysql/Subscriptions");
const Transactions = require("../models/mysql/Transactions");
const SubscriptionPlans = require("../models/mysql/SubscriptionPlans");
const PaymentMethods = require("../models/mysql/PaymentMethods");
const SubscriptionEvents = require("../models/mysql/SubscriptionEvents");
const BillingActivityLogs = require("../models/mysql/BillingActivityLogs");
const WebhookEvents = require("../models/mysql/WebhookEvents");
const BillingNotifications = require("../models/mysql/BillingNotifications");
const emailService = require("./emailService");

exports.createSubscription = async ({ customerData, priceId }) => {
  console.log("Creating subscription for: ".green, customerData);
  console.log("Using price ID: ".green, priceId);

  // SECURITY: Look up plan from database by priceId - never trust frontend trial data
  const plan = await SubscriptionPlans.findOne({
    where: {
      [require('sequelize').Op.or]: [
        { stripe_price_id: priceId },
        { stripe_yearly_price_id: priceId }
      ],
      active: true
    }
  });

  if (!plan) {
    return {
      success: false,
      error: "Invalid plan selected. Please try again."
    };
  }

  // SECURITY: Only use trial_period_days if trial_enabled is true in the database
  const trialDays = (plan.trial_enabled && plan.trial_period_days > 0) ? plan.trial_period_days : 0;
  console.log("Plan found: ".green, plan.name, "Trial enabled:", plan.trial_enabled, "Trial days:", trialDays);

  let user = await User.findOne({ where: { email: customerData.email } });
  if(user){
    console.log("user already exists: ".red,user.uuid);
    return {
      success: false,
      error: "User with this email already exists. Try Another email."
    };
  }

  let user_uuid = user?.user_uuid;
  const hashedPassword = await bcrypt.hash(customerData.password, 10);
  user_uuid = uuidv4();
  if (!user) {
    user = await User.create({
      uuid: user_uuid,
      firstName: customerData.firstName,
      lastName: customerData.lastName,
      email: customerData.email,
      password: hashedPassword,
      status: "0",
      onboard_status: "0"
    });
  }

  const customer = await stripe.customers.create({
    email: customerData.email,
    name: `${customerData.firstName} ${customerData.lastName}`,
    phone: customerData.phone,
    metadata: { userUuid: user_uuid },
  });

  await User.update(
    { stripe_customer_id: customer.id },
    { where: { uuid: user_uuid } }
  );

  // Step 1: Create SetupIntent to collect payment method first
  const setupIntent = await stripe.setupIntents.create({
    customer: customer.id,
    payment_method_types: ["card"],
    usage: "off_session",
    metadata: {
      user_uuid: user_uuid,
      price_id: priceId,
      plan_name: plan.name,
      trial_days: trialDays.toString(),
    },
  });

  console.log("SetupIntent created:".green, setupIntent.id);

  return {
    success: true,
    setupIntentId: setupIntent.id,
    customerId: customer.id,
    user_uuid,
    clientSecret: setupIntent.client_secret,
    planName: plan.name,
    priceId: priceId,
    trialDays: trialDays
  };
};

exports.confirmPayment = async ({ user_uuid, setupIntentId, paymentMethodId, priceId, customerId }) => {
  console.log("Confirming payment:".green, { user_uuid, setupIntentId, paymentMethodId, priceId, customerId });

  // Get the payment method from the SetupIntent if not provided directly
  let pmId = paymentMethodId;
  if (!pmId && setupIntentId) {
    const setupIntent = await stripe.setupIntents.retrieve(setupIntentId);
    pmId = setupIntent.payment_method;
  }

  if (!pmId) {
    return {
      success: false,
      error: "No payment method found. Please try again."
    };
  }

  // Attach payment method to customer and set as default
  await stripe.paymentMethods.attach(pmId, { customer: customerId });
  await stripe.customers.update(customerId, {
    invoice_settings: { default_payment_method: pmId },
  });

  // Get plan details from database
  const plan = await SubscriptionPlans.findOne({
    where: {
      [require('sequelize').Op.or]: [
        { stripe_price_id: priceId },
        { stripe_yearly_price_id: priceId }
      ],
      active: true
    }
  });

  if (!plan) {
    return {
      success: false,
      error: "Invalid plan. Please try again."
    };
  }

  // Determine trial days from database
  const trialDays = (plan.trial_enabled && plan.trial_period_days > 0) ? plan.trial_period_days : 0;

  // Create the subscription with the payment method
  const subscriptionParams = {
    customer: customerId,
    items: [{ price: priceId }],
    default_payment_method: pmId,
    expand: ["latest_invoice"],
  };

  if (trialDays > 0) {
    subscriptionParams.trial_period_days = trialDays;
  }

  const subscription = await stripe.subscriptions.create(subscriptionParams);
  console.log("Subscription created:".green, subscription.id, "Status:", subscription.status);

  const savedSubscription = await Subscriptions.create({
    user_uuid,
    plan_id: plan?.id || null,
    stripe_customer_id: subscription.customer,
    stripe_subscription_id: subscription.id,
    stripe_price_id: subscription.items.data[0].price.id,
    price_id: subscription.items.data[0].price.id,
    status: subscription.status,
    trial_start: subscription.trial_start ? new Date(subscription.trial_start * 1000) : null,
    trial_end: subscription.trial_end ? new Date(subscription.trial_end * 1000) : null,
    trial_days: subscription.trial_end && subscription.trial_start 
      ? Math.round((subscription.trial_end - subscription.trial_start) / 86400) 
      : null,
    current_period_start: subscription.current_period_start ? new Date(subscription.current_period_start * 1000) : null,
    current_period_end: subscription.current_period_end ? new Date(subscription.current_period_end * 1000) : null,
    billing_cycle_anchor: subscription.billing_cycle_anchor ? new Date(subscription.billing_cycle_anchor * 1000) : null,
    next_invoice_date: subscription.current_period_end ? new Date(subscription.current_period_end * 1000) : null,
    collection_method: subscription.collection_method,
    quantity: subscription.items.data[0].quantity || 1,
    amount: subscription.items.data[0].price.unit_amount, // Store in cents
    currency: subscription.items.data[0].price.currency.toUpperCase(),
    billing_interval: subscription.items.data[0].price.recurring?.interval || 'month',
    cancel_at_period_end: subscription.cancel_at_period_end || false,
    synced_at: new Date()
  });

  await SubscriptionEvents.create({
    subscription_id: savedSubscription.id,
    user_uuid,
    stripe_subscription_id: subscription.id,
    event_type: 'subscription_created',
    new_status: subscription.status,
    actor: 'user',
    description: `Subscription created with ${subscription.status === 'trialing' ? 'trial period' : 'active status'}`,
    occurred_at: new Date(),
    processed_at: new Date()
  });

  await BillingActivityLogs.create({
    user_uuid,
    subscription_id: savedSubscription.id,
    action_type: 'subscription_created',
    action_status: 'success',
    actor_type: 'user',
    new_value: {
      plan_id: plan?.id,
      status: subscription.status,
      trial_end: subscription.trial_end ? new Date(subscription.trial_end * 1000) : null
    },
    stripe_object_id: subscription.id,
    description: `New subscription created for plan ${plan?.name || 'Unknown'}`
  });

  if (subscription.status === 'trialing' && subscription.trial_end) {
    const trialEndDate = new Date(subscription.trial_end * 1000);
    const reminder24h = new Date(trialEndDate.getTime() - 24 * 60 * 60 * 1000);
    const reminder1h = new Date(trialEndDate.getTime() - 1 * 60 * 60 * 1000);

    const user = await User.findOne({ where: { uuid: user_uuid } });
    
    if (reminder24h > new Date()) {
      await BillingNotifications.create({
        user_uuid,
        subscription_id: savedSubscription.id,
        notification_type: 'trial_ending_24h',
        channel: 'email',
        priority: 'high',
        status: 'pending',
        recipient_email: user?.email,
        subject: 'Your trial ends tomorrow',
        template_name: 'trial_ending_24h',
        template_data: {
          firstName: user?.firstName,
          planName: plan?.name,
          trialEndDate: trialEndDate.toISOString()
        },
        scheduled_at: reminder24h
      });
    }

    if (reminder1h > new Date()) {
      await BillingNotifications.create({
        user_uuid,
        subscription_id: savedSubscription.id,
        notification_type: 'trial_ending_1h',
        channel: 'email',
        priority: 'urgent',
        status: 'pending',
        recipient_email: user?.email,
        subject: 'Your trial ends in 1 hour',
        template_name: 'trial_ending_1h',
        template_data: {
          firstName: user?.firstName,
          planName: plan?.name,
          trialEndDate: trialEndDate.toISOString()
        },
        scheduled_at: reminder1h
      });
    }
  }

  await User.update(
    { status: "1" },
    { where: { uuid: user_uuid } }
  );

  try {
    const user = await User.findOne({ where: { uuid: user_uuid } });
    
    const planName = plan?.name || 'Subscription';
    const isTrialing = subscription.status === 'trialing' && subscription.trial_end;
    const actualTrialDays = isTrialing && subscription.trial_end && subscription.trial_start
      ? Math.round((subscription.trial_end - subscription.trial_start) / 86400)
      : 0;
    
    const isYearly = plan?.stripe_yearly_price_id === subscription.items.data[0].price.id;
    const price = isYearly ? plan?.yearly_price : plan?.price;
    const billingInterval = isYearly ? 'year' : 'month';

    emailService.initialize();
    
    if (user && user.email) {
      await emailService.sendWelcomeEmail({
        to: user.email,
        firstName: user.firstName,
        planName: planName,
        trialDays: actualTrialDays > 0 ? actualTrialDays : null,
        price: price,
        billingInterval: billingInterval,
        dashboardUrl: process.env.APP_URL || 'https://app.insocialwise.com'
      });
      console.log(`Welcome email sent to ${user.email} (${isTrialing ? `${actualTrialDays}-day trial` : 'direct paid'})`);
    }
  } catch (emailError) {
    console.error('Error sending welcome email:', emailError.message);
  }

  return {
    success: true,
    user_uuid: user_uuid,
    subscriptionId: savedSubscription.id
  };
};

// SECURITY: Verify subscription details by user token - returns accurate data from database
exports.verifySubscription = async (token) => {
  if (!token) {
    return { success: false, error: "Token is required" };
  }

  const user = await User.findOne({ where: { uuid: token } });
  if (!user) {
    return { success: false, error: "Invalid token" };
  }

  const subscription = await Subscriptions.findOne({
    where: { user_uuid: token },
    order: [['createdAt', 'DESC']]
  });

  if (!subscription) {
    return { success: false, error: "No subscription found" };
  }

  const plan = await SubscriptionPlans.findByPk(subscription.plan_id);

  // Parse display_features
  let displayFeatures = [];
  if (plan?.display_features) {
    if (typeof plan.display_features === 'string') {
      try {
        displayFeatures = JSON.parse(plan.display_features);
      } catch (e) {
        displayFeatures = [];
      }
    } else if (Array.isArray(plan.display_features)) {
      displayFeatures = plan.display_features;
    }
  }

  // Calculate actual trial days from subscription
  const isTrialing = subscription.status === 'trialing';
  const actualTrialDays = subscription.trial_days || 0;
  const trialEndDate = subscription.trial_end;

  return {
    success: true,
    subscription: {
      id: subscription.id,
      status: subscription.status,
      isTrialing: isTrialing,
      trialDays: actualTrialDays,
      trialEnd: trialEndDate,
      currentPeriodStart: subscription.current_period_start,
      currentPeriodEnd: subscription.current_period_end,
      billingInterval: subscription.billing_interval,
      amount: subscription.amount,
      currency: subscription.currency
    },
    plan: plan ? {
      id: plan.id,
      name: plan.name,
      price: plan.price,
      yearlyPrice: plan.yearly_price,
      features: displayFeatures,
      trialEnabled: plan.trial_enabled,
      trialPeriodDays: plan.trial_period_days
    } : null,
    user: {
      firstName: user.firstName,
      lastName: user.lastName,
      email: user.email
    }
  };
};

exports.processWebhook = async (req, res) => {
  const startTime = Date.now();
  const sig = req.headers["stripe-signature"];
  const webhookSecret = process.env.STRIPE_WEBHOOK_SECRET;

  if (!webhookSecret) {
    console.error("STRIPE_WEBHOOK_SECRET is not configured");
    return res.status(500).json({ error: "Webhook secret not configured" });
  }

  if (!sig) {
    console.error("Missing stripe-signature header");
    return res.status(400).json({ error: "Missing signature" });
  }

  let event;
  let signatureVerified = false;
  try {
    event = stripe.webhooks.constructEvent(req.body, sig, webhookSecret);
    signatureVerified = true;
  } catch (err) {
    console.error(`Webhook signature verification failed: ${err.message}`);
    return res.status(400).json({ error: `Webhook Error: ${err.message}` });
  }

  const existingEvent = await WebhookEvents.findOne({
    where: { stripe_event_id: event.id }
  });

  if (existingEvent) {
    console.log(`Webhook event ${event.id} already processed, skipping`);
    return res.json({ received: true, status: 'already_processed' });
  }

  const payloadHash = crypto.createHash('sha256').update(JSON.stringify(event)).digest('hex');
  
  const webhookEvent = await WebhookEvents.create({
    stripe_event_id: event.id,
    event_type: event.type,
    api_version: event.api_version,
    livemode: event.livemode,
    object_type: event.data.object?.object,
    object_id: event.data.object?.id,
    customer_id: event.data.object?.customer,
    subscription_id: event.data.object?.subscription || (event.type.includes('subscription') ? event.data.object?.id : null),
    invoice_id: event.type.includes('invoice') ? event.data.object?.id : event.data.object?.invoice,
    payment_intent_id: event.data.object?.payment_intent,
    payload: event,
    payload_hash: payloadHash,
    status: 'processing',
    received_at: new Date(),
    ip_address: req.ip || req.headers['x-forwarded-for'],
    signature_verified: signatureVerified
  });

  console.log(`Processing Stripe webhook: ${event.type} (${event.id})`);

  const actionsTaken = [];
  const affectedRecords = [];
  let errorOccurred = null;

  try {
    switch (event.type) {
      case "customer.subscription.created": {
        const subscription = event.data.object;
        actionsTaken.push('subscription_created_logged');
        break;
      }

      case "customer.subscription.updated": {
        const subscription = event.data.object;
        const previousAttributes = event.data.previous_attributes || {};
        
        const sub = await Subscriptions.findOne({
          where: { stripe_subscription_id: subscription.id }
        });

        if (sub) {
          const oldStatus = sub.status;
          const updates = {
            status: subscription.status,
            current_period_start: subscription.current_period_start ? new Date(subscription.current_period_start * 1000) : null,
            current_period_end: subscription.current_period_end ? new Date(subscription.current_period_end * 1000) : null,
            next_invoice_date: subscription.current_period_end ? new Date(subscription.current_period_end * 1000) : null,
            cancel_at_period_end: subscription.cancel_at_period_end,
            cancel_at: subscription.cancel_at ? new Date(subscription.cancel_at * 1000) : null,
            canceled_at: subscription.canceled_at ? new Date(subscription.canceled_at * 1000) : null,
            ended_at: subscription.ended_at ? new Date(subscription.ended_at * 1000) : null,
            latest_invoice_id: subscription.latest_invoice,
            synced_at: new Date()
          };

          if (subscription.status === 'past_due' && oldStatus !== 'past_due') {
            updates.past_due_since = new Date();
            updates.dunning_status = 'in_progress';
          }

          if (subscription.status === 'active' && oldStatus === 'past_due') {
            updates.past_due_since = null;
            updates.dunning_status = 'none';
            updates.payment_retry_count = 0;
          }

          await Subscriptions.update(updates, {
            where: { stripe_subscription_id: subscription.id }
          });

          affectedRecords.push({ type: 'subscription', id: sub.id });
          actionsTaken.push('subscription_updated');

          await SubscriptionEvents.create({
            subscription_id: sub.id,
            user_uuid: sub.user_uuid,
            stripe_subscription_id: subscription.id,
            stripe_event_id: event.id,
            event_type: oldStatus !== subscription.status ? 'status_changed' : 'subscription_updated',
            old_status: oldStatus,
            new_status: subscription.status,
            actor: 'stripe',
            actor_id: 'webhook',
            description: `Subscription updated: ${oldStatus} → ${subscription.status}`,
            metadata: previousAttributes,
            event_payload: event.data.object,
            occurred_at: new Date(event.created * 1000),
            processed_at: new Date()
          });

          await BillingActivityLogs.create({
            user_uuid: sub.user_uuid,
            subscription_id: sub.id,
            action_type: 'subscription_updated',
            action_status: 'success',
            actor_type: 'stripe',
            old_value: { status: oldStatus },
            new_value: { status: subscription.status },
            stripe_event_id: event.id,
            stripe_object_id: subscription.id,
            description: `Subscription status changed from ${oldStatus} to ${subscription.status}`
          });
        }
        break;
      }

      case "customer.subscription.deleted": {
        const subscription = event.data.object;
        
        const sub = await Subscriptions.findOne({
          where: { stripe_subscription_id: subscription.id }
        });

        if (sub) {
          const oldStatus = sub.status;
          
          await Subscriptions.update({
            status: 'canceled',
            ended_at: new Date(),
            canceled_at: subscription.canceled_at ? new Date(subscription.canceled_at * 1000) : new Date(),
            synced_at: new Date()
          }, {
            where: { stripe_subscription_id: subscription.id }
          });

          affectedRecords.push({ type: 'subscription', id: sub.id });
          actionsTaken.push('subscription_canceled');

          await SubscriptionEvents.create({
            subscription_id: sub.id,
            user_uuid: sub.user_uuid,
            stripe_subscription_id: subscription.id,
            stripe_event_id: event.id,
            event_type: 'subscription_deleted',
            old_status: oldStatus,
            new_status: 'canceled',
            actor: 'stripe',
            description: 'Subscription canceled/deleted',
            event_payload: event.data.object,
            occurred_at: new Date(event.created * 1000),
            processed_at: new Date()
          });

          await BillingActivityLogs.create({
            user_uuid: sub.user_uuid,
            subscription_id: sub.id,
            action_type: 'subscription_canceled',
            action_status: 'success',
            actor_type: 'stripe',
            old_value: { status: oldStatus },
            new_value: { status: 'canceled' },
            stripe_event_id: event.id,
            stripe_object_id: subscription.id,
            description: 'Subscription was canceled'
          });
        }
        break;
      }

      case "invoice.created": {
        const invoice = event.data.object;
        
        const sub = await Subscriptions.findOne({
          where: { stripe_subscription_id: invoice.subscription }
        });

        if (sub) {
          await Transactions.create({
            user_uuid: sub.user_uuid,
            subscription_id: sub.id,
            plan_id: sub.plan_id,
            stripe_invoice_id: invoice.id,
            stripe_subscription_id: invoice.subscription,
            stripe_customer_id: invoice.customer,
            invoice_number: invoice.number,
            invoice_pdf_url: invoice.invoice_pdf,
            invoice_hosted_url: invoice.hosted_invoice_url,
            billing_reason: invoice.billing_reason,
            amount_subtotal: invoice.subtotal,
            amount_tax: invoice.tax || 0,
            amount_total: invoice.total,
            amount: invoice.total,
            amount_due: invoice.amount_due,
            currency: invoice.currency,
            status: 'open',
            due_date: invoice.due_date ? new Date(invoice.due_date * 1000) : null,
            period_start: invoice.period_start ? new Date(invoice.period_start * 1000) : null,
            period_end: invoice.period_end ? new Date(invoice.period_end * 1000) : null
          });

          actionsTaken.push('invoice_created');
          
          await BillingActivityLogs.create({
            user_uuid: sub.user_uuid,
            subscription_id: sub.id,
            action_type: 'invoice_created',
            action_status: 'success',
            actor_type: 'stripe',
            amount: invoice.total,
            currency: invoice.currency,
            stripe_event_id: event.id,
            stripe_object_id: invoice.id,
            description: `Invoice ${invoice.number} created for ${invoice.total / 100} ${invoice.currency.toUpperCase()}`
          });
        }
        break;
      }

      case "invoice.payment_succeeded": {
        const invoice = event.data.object;

        const sub = await Subscriptions.findOne({
          where: { stripe_subscription_id: invoice.subscription }
        });

        if (sub) {
          const existingTx = await Transactions.findOne({
            where: { stripe_invoice_id: invoice.id }
          });

          if (existingTx) {
            await Transactions.update({
              status: 'paid',
              payment_status: 'succeeded',
              stripe_payment_intent_id: invoice.payment_intent,
              stripe_charge_id: invoice.charge,
              amount_paid: invoice.amount_paid,
              amount_remaining: invoice.amount_remaining,
              paid_at: new Date(),
              invoice_pdf_url: invoice.invoice_pdf,
              invoice_hosted_url: invoice.hosted_invoice_url,
              receipt_url: invoice.charge ? (await stripe.charges.retrieve(invoice.charge))?.receipt_url : null
            }, {
              where: { stripe_invoice_id: invoice.id }
            });
            affectedRecords.push({ type: 'transaction', id: existingTx.id, action: 'updated' });
          } else {
            const newTx = await Transactions.create({
              user_uuid: sub.user_uuid,
              subscription_id: sub.id,
              plan_id: sub.plan_id,
              stripe_invoice_id: invoice.id,
              stripe_payment_intent_id: invoice.payment_intent,
              stripe_charge_id: invoice.charge,
              stripe_subscription_id: invoice.subscription,
              stripe_customer_id: invoice.customer,
              invoice_number: invoice.number,
              invoice_pdf_url: invoice.invoice_pdf,
              invoice_hosted_url: invoice.hosted_invoice_url,
              billing_reason: invoice.billing_reason,
              amount_subtotal: invoice.subtotal,
              amount_tax: invoice.tax || 0,
              amount_total: invoice.total,
              amount: invoice.amount_paid,
              amount_paid: invoice.amount_paid,
              amount_due: invoice.amount_due,
              amount_remaining: invoice.amount_remaining,
              currency: invoice.currency,
              status: 'paid',
              payment_status: 'succeeded',
              paid_at: new Date(),
              period_start: invoice.period_start ? new Date(invoice.period_start * 1000) : null,
              period_end: invoice.period_end ? new Date(invoice.period_end * 1000) : null
            });
            affectedRecords.push({ type: 'transaction', id: newTx.id, action: 'created' });
          }

          actionsTaken.push('payment_succeeded');

          await Subscriptions.update({
            past_due_since: null,
            dunning_status: 'none',
            payment_retry_count: 0,
            last_payment_error: null,
            synced_at: new Date()
          }, {
            where: { id: sub.id }
          });

          await SubscriptionEvents.create({
            subscription_id: sub.id,
            user_uuid: sub.user_uuid,
            stripe_subscription_id: invoice.subscription,
            stripe_event_id: event.id,
            event_type: 'payment_succeeded',
            amount: invoice.amount_paid,
            currency: invoice.currency,
            actor: 'stripe',
            description: `Payment of ${invoice.amount_paid / 100} ${invoice.currency.toUpperCase()} succeeded`,
            occurred_at: new Date(event.created * 1000),
            processed_at: new Date()
          });

          await BillingActivityLogs.create({
            user_uuid: sub.user_uuid,
            subscription_id: sub.id,
            action_type: 'payment_succeeded',
            action_status: 'success',
            actor_type: 'stripe',
            amount: invoice.amount_paid,
            currency: invoice.currency,
            stripe_event_id: event.id,
            stripe_object_id: invoice.id,
            description: `Payment of ${invoice.amount_paid / 100} ${invoice.currency.toUpperCase()} succeeded for invoice ${invoice.number}`
          });
        }
        break;
      }

      case "invoice.payment_failed": {
        const invoice = event.data.object;

        const sub = await Subscriptions.findOne({
          where: { stripe_subscription_id: invoice.subscription }
        });

        if (sub) {
          const paymentIntent = invoice.payment_intent ? 
            await stripe.paymentIntents.retrieve(invoice.payment_intent) : null;

          const failureCode = paymentIntent?.last_payment_error?.code || 'unknown';
          const failureMessage = paymentIntent?.last_payment_error?.message || 'Payment failed';

          const existingTx = await Transactions.findOne({
            where: { stripe_invoice_id: invoice.id }
          });

          if (existingTx) {
            await Transactions.update({
              status: 'failed',
              payment_status: 'failed',
              failure_code: failureCode,
              failure_message: failureMessage,
              failure_reason: paymentIntent?.last_payment_error?.decline_code,
              attempt_count: invoice.attempt_count,
              next_payment_attempt: invoice.next_payment_attempt ? new Date(invoice.next_payment_attempt * 1000) : null
            }, {
              where: { stripe_invoice_id: invoice.id }
            });
          } else {
            await Transactions.create({
              user_uuid: sub.user_uuid,
              subscription_id: sub.id,
              plan_id: sub.plan_id,
              stripe_invoice_id: invoice.id,
              stripe_payment_intent_id: invoice.payment_intent,
              stripe_subscription_id: invoice.subscription,
              stripe_customer_id: invoice.customer,
              invoice_number: invoice.number,
              billing_reason: invoice.billing_reason,
              amount_subtotal: invoice.subtotal,
              amount_tax: invoice.tax || 0,
              amount_total: invoice.total,
              amount: invoice.total,
              amount_due: invoice.amount_due,
              currency: invoice.currency,
              status: 'failed',
              payment_status: 'failed',
              failure_code: failureCode,
              failure_message: failureMessage,
              failure_reason: paymentIntent?.last_payment_error?.decline_code,
              attempt_count: invoice.attempt_count,
              next_payment_attempt: invoice.next_payment_attempt ? new Date(invoice.next_payment_attempt * 1000) : null,
              period_start: invoice.period_start ? new Date(invoice.period_start * 1000) : null,
              period_end: invoice.period_end ? new Date(invoice.period_end * 1000) : null
            });
          }

          await Subscriptions.update({
            last_payment_attempt_at: new Date(),
            last_payment_error: failureMessage,
            payment_retry_count: (sub.payment_retry_count || 0) + 1,
            next_payment_retry_at: invoice.next_payment_attempt ? new Date(invoice.next_payment_attempt * 1000) : null,
            synced_at: new Date()
          }, {
            where: { id: sub.id }
          });

          actionsTaken.push('payment_failed_recorded');

          await SubscriptionEvents.create({
            subscription_id: sub.id,
            user_uuid: sub.user_uuid,
            stripe_subscription_id: invoice.subscription,
            stripe_event_id: event.id,
            event_type: 'payment_failed',
            amount: invoice.amount_due,
            currency: invoice.currency,
            failure_code: failureCode,
            failure_message: failureMessage,
            actor: 'stripe',
            description: `Payment failed: ${failureMessage}`,
            occurred_at: new Date(event.created * 1000),
            processed_at: new Date()
          });

          await BillingActivityLogs.create({
            user_uuid: sub.user_uuid,
            subscription_id: sub.id,
            action_type: 'payment_failed',
            action_status: 'failed',
            actor_type: 'stripe',
            amount: invoice.amount_due,
            currency: invoice.currency,
            error_code: failureCode,
            error_message: failureMessage,
            stripe_event_id: event.id,
            stripe_object_id: invoice.id,
            description: `Payment failed for invoice ${invoice.number}: ${failureMessage}`
          });

          const user = await User.findOne({ where: { uuid: sub.user_uuid } });
          if (user) {
            await BillingNotifications.create({
              user_uuid: sub.user_uuid,
              subscription_id: sub.id,
              notification_type: 'payment_failed',
              channel: 'email',
              priority: 'urgent',
              status: 'pending',
              recipient_email: user.email,
              subject: 'Payment Failed - Action Required',
              template_name: 'payment_failed',
              template_data: {
                firstName: user.firstName,
                amount: invoice.amount_due / 100,
                currency: invoice.currency.toUpperCase(),
                failureReason: failureMessage,
                nextRetry: invoice.next_payment_attempt ? new Date(invoice.next_payment_attempt * 1000) : null
              },
              scheduled_at: new Date()
            });
          }
        }
        break;
      }

      case "charge.refunded": {
        const charge = event.data.object;
        
        const tx = await Transactions.findOne({
          where: { stripe_charge_id: charge.id }
        });

        if (tx) {
          const refundAmount = charge.amount_refunded;
          const isFullRefund = charge.refunded && charge.amount_refunded === charge.amount;

          await Transactions.update({
            status: isFullRefund ? 'refunded' : 'partially_refunded',
            refund_amount: refundAmount,
            refunded_at: new Date(),
            stripe_refund_id: charge.refunds?.data?.[0]?.id
          }, {
            where: { stripe_charge_id: charge.id }
          });

          actionsTaken.push('refund_processed');

          await BillingActivityLogs.create({
            user_uuid: tx.user_uuid,
            subscription_id: tx.subscription_id,
            transaction_id: tx.id,
            action_type: 'payment_refunded',
            action_status: 'success',
            actor_type: 'stripe',
            amount: refundAmount,
            currency: charge.currency,
            stripe_event_id: event.id,
            stripe_object_id: charge.id,
            description: `${isFullRefund ? 'Full' : 'Partial'} refund of ${refundAmount / 100} ${charge.currency.toUpperCase()}`
          });
        }
        break;
      }

      case "payment_method.attached": {
        const paymentMethod = event.data.object;
        const customerId = paymentMethod.customer;

        const user = await User.findOne({
          where: { stripe_customer_id: customerId }
        });

        if (user) {
          await PaymentMethods.create({
            user_uuid: user.uuid,
            stripe_customer_id: customerId,
            stripe_payment_method_id: paymentMethod.id,
            type: paymentMethod.type,
            brand: paymentMethod.card?.brand,
            last4: paymentMethod.card?.last4,
            exp_month: paymentMethod.card?.exp_month,
            exp_year: paymentMethod.card?.exp_year,
            funding: paymentMethod.card?.funding,
            country: paymentMethod.card?.country,
            billing_details: paymentMethod.billing_details,
            fingerprint: paymentMethod.card?.fingerprint,
            wallet: paymentMethod.card?.wallet?.type,
            is_default: false,
            status: 'active'
          });

          actionsTaken.push('payment_method_added');

          await BillingActivityLogs.create({
            user_uuid: user.uuid,
            action_type: 'card_added',
            action_status: 'success',
            actor_type: 'stripe',
            new_value: {
              brand: paymentMethod.card?.brand,
              last4: paymentMethod.card?.last4
            },
            stripe_event_id: event.id,
            stripe_object_id: paymentMethod.id,
            description: `Payment method added: ${paymentMethod.card?.brand} ending in ${paymentMethod.card?.last4}`
          });
        }
        break;
      }

      case "payment_method.detached": {
        const paymentMethod = event.data.object;

        await PaymentMethods.update({
          status: 'deleted'
        }, {
          where: { stripe_payment_method_id: paymentMethod.id }
        });

        actionsTaken.push('payment_method_removed');
        break;
      }

      case "customer.subscription.trial_will_end": {
        const subscription = event.data.object;
        
        const sub = await Subscriptions.findOne({
          where: { stripe_subscription_id: subscription.id }
        });

        if (sub) {
          await SubscriptionEvents.create({
            subscription_id: sub.id,
            user_uuid: sub.user_uuid,
            stripe_subscription_id: subscription.id,
            stripe_event_id: event.id,
            event_type: 'trial_ending',
            actor: 'stripe',
            description: `Trial ending in 3 days`,
            occurred_at: new Date(event.created * 1000),
            processed_at: new Date()
          });

          actionsTaken.push('trial_ending_logged');
        }
        break;
      }

      default:
        actionsTaken.push(`unhandled_event_${event.type}`);
        console.log(`Unhandled event type: ${event.type}`);
    }

    const processingTime = Date.now() - startTime;
    
    await WebhookEvents.update({
      status: 'processed',
      processed_at: new Date(),
      processing_time_ms: processingTime,
      actions_taken: actionsTaken,
      affected_records: affectedRecords
    }, {
      where: { id: webhookEvent.id }
    });

  } catch (error) {
    errorOccurred = error;
    console.error(`Error processing webhook ${event.id}:`, error);

    await WebhookEvents.update({
      status: 'failed',
      error_code: error.code || 'PROCESSING_ERROR',
      error_message: error.message,
      error_stack: error.stack,
      processing_attempts: webhookEvent.processing_attempts + 1,
      next_retry_at: new Date(Date.now() + 5 * 60 * 1000)
    }, {
      where: { id: webhookEvent.id }
    });

    await BillingActivityLogs.create({
      action_type: 'webhook_processed',
      action_status: 'failed',
      actor_type: 'system',
      error_code: error.code || 'PROCESSING_ERROR',
      error_message: error.message,
      stripe_event_id: event.id,
      description: `Webhook processing failed: ${error.message}`
    });
  }

  res.json({ received: true });
};
