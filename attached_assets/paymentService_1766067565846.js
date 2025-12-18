const stripeKey = process.env.STRIPE_SECRET_KEY;
const stripe = stripeKey ? require("stripe")(stripeKey) : null;
const { v4: uuidv4 } = require("uuid");
const bcrypt = require("bcryptjs");
const crypto = require("crypto");

const User = require("../models/postgres/User");
const Subscriptions = require("../models/postgres/Subscription");
const SubscriptionPlans = require("../models/postgres/SubscriptionPlans");
const PaymentMethods = require("../models/postgres/PaymentMethods");
const BillingActivityLogs = require("../models/postgres/BillingActivityLogs");
const emailService = require("./emailService");

exports.createSubscription = async ({ customerData, priceId }) => {
  console.log("Creating subscription for: ".green, customerData);
  console.log("Using price ID: ".green, priceId);

  // SECURITY: Look up plan from database by priceId - never trust frontend trial data
  const plan = await SubscriptionPlans.findOne({
    where: {
      [require("sequelize").Op.or]: [
        { stripe_price_id: priceId },
        { stripe_yearly_price_id: priceId },
      ],
      active: 1,
    },
  });

  if (!plan) {
    return {
      success: false,
      error: "Invalid plan selected. Please try again.",
    };
  }

  // SECURITY: Only use trial_period_days if trial_enabled is true in the database
  const trialDays =
    plan.trial_enabled === 1 && plan.trial_period_days > 0
      ? plan.trial_period_days
      : 0;
  console.log(
    "Plan found: ".green,
    plan.name,
    "Trial enabled:",
    plan.trial_enabled,
    "Trial days:",
    trialDays,
  );

  let user = await User.findOne({ where: { email: customerData.email } });
  if (user) {
    console.log("user already exists: ".red, user.uuid);
    return {
      success: false,
      error: "User with this email already exists. Try Another email.",
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
      onboard_status: "0",
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
    { where: { uuid: user_uuid } },
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
    trialDays: trialDays,
  };
};

exports.confirmPayment = async ({
  user_uuid,
  setupIntentId,
  paymentMethodId,
  priceId,
  customerId,
}) => {
  console.log("Confirming payment:".green, {
    user_uuid,
    setupIntentId,
    paymentMethodId,
    priceId,
    customerId,
  });

  // Get the payment method from the SetupIntent if not provided directly
  let pmId = paymentMethodId;
  if (!pmId && setupIntentId) {
    const setupIntent = await stripe.setupIntents.retrieve(setupIntentId);
    pmId = setupIntent.payment_method;
  }

  if (!pmId) {
    return {
      success: false,
      error: "No payment method found. Please try again.",
    };
  }

  // Attach payment method to customer and set as default
  await stripe.paymentMethods.attach(pmId, { customer: customerId });
  await stripe.customers.update(customerId, {
    invoice_settings: { default_payment_method: pmId },
  });

  // Fetch payment method details to store in database
  const paymentMethodDetails = await stripe.paymentMethods.retrieve(pmId);
  
  // Store payment method in database
  let cardBrand = null;
  let cardLast4 = null;
  let cardExpMonth = null;
  let cardExpYear = null;
  
  if (paymentMethodDetails.type === 'card' && paymentMethodDetails.card) {
    cardBrand = paymentMethodDetails.card.brand?.toUpperCase() || null;
    cardLast4 = paymentMethodDetails.card.last4 || null;
    cardExpMonth = paymentMethodDetails.card.exp_month || null;
    cardExpYear = paymentMethodDetails.card.exp_year || null;
  }
  
  await PaymentMethods.create({
    user_uuid,
    stripe_payment_method_id: pmId,
    stripe_customer_id: customerId,
    type: paymentMethodDetails.type,
    card_brand: cardBrand,
    card_last4: cardLast4,
    exp_month: cardExpMonth,
    exp_year: cardExpYear,
    is_default: 1,
    status: 'active',
  });

  console.log("Payment method stored in database for user:", user_uuid);

  // Get plan details from database
  const plan = await SubscriptionPlans.findOne({
    where: {
      [require("sequelize").Op.or]: [
        { stripe_price_id: priceId },
        { stripe_yearly_price_id: priceId },
      ],
      active: 1,
    },
  });

  if (!plan) {
    return {
      success: false,
      error: "Invalid plan. Please try again.",
    };
  }

  // Determine trial days from database
  const trialDays =
    plan.trial_enabled === 1 && plan.trial_period_days > 0
      ? plan.trial_period_days
      : 0;

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

  let subscription;
  try {
    subscription = await stripe.subscriptions.create(subscriptionParams);
    console.log(
      "Subscription created:".green,
      subscription.id,
      "Status:",
      subscription.status,
    );
  } catch (stripeError) {
    console.error("Stripe subscription creation failed:".red, {
      code: stripeError.code,
      message: stripeError.message,
      type: stripeError.type,
    });
    
    // Payment method exists but subscription creation failed
    if (stripeError.code === 'card_declined' || stripeError.code === 'charge_exceeds_open_invoices_limit') {
      return {
        success: false,
        error: "Payment declined. Your subscription could not be created. Please try again with a different card.",
        errorCode: stripeError.code,
      };
    }
    
    if (stripeError.code === 'resource_missing') {
      return {
        success: false,
        error: "Payment method or subscription configuration is invalid. Please contact support.",
        errorCode: stripeError.code,
      };
    }
    
    throw stripeError; // Re-throw for 500 error handling in controller
  }

  console.log("DEBUG: Plan object:", { planId: plan?.id, planName: plan?.name, planActive: plan?.active });
  
  const savedSubscription = await Subscriptions.create({
    user_uuid,
    plan_id: plan?.id || null,
    stripe_customer_id: subscription.customer,
    stripe_subscription_id: subscription.id,
    stripe_price_id: subscription.items.data[0].price.id,
    price_id: subscription.items.data[0].price.id,
    status: subscription.status,
    trial_start: subscription.trial_start
      ? new Date(subscription.trial_start * 1000)
      : null,
    trial_end: subscription.trial_end
      ? new Date(subscription.trial_end * 1000)
      : null,
    trial_days:
      subscription.trial_end && subscription.trial_start
        ? Math.round(
            (subscription.trial_end - subscription.trial_start) / 86400,
          )
        : null,
    current_period_start: subscription.current_period_start
      ? new Date(subscription.current_period_start * 1000)
      : null,
    current_period_end: subscription.current_period_end
      ? new Date(subscription.current_period_end * 1000)
      : null,
    billing_cycle_anchor: subscription.billing_cycle_anchor
      ? new Date(subscription.billing_cycle_anchor * 1000)
      : null,
    next_invoice_date: subscription.next_invoice_date
      ? new Date(subscription.next_invoice_date * 1000)
      : null,
    collection_method: subscription.collection_method,
    quantity: subscription.items.data[0].quantity || 1,
    amount: subscription.items.data[0].price.unit_amount, // Store in cents
    currency: subscription.items.data[0].price.currency.toUpperCase(),
    billing_interval:
      subscription.items.data[0].price.recurring?.interval || "month",
    cancel_at_period_end: subscription.cancel_at_period_end ? 1 : 0,
    cancel_at: subscription.cancel_at
      ? new Date(subscription.cancel_at * 1000)
      : null,
    canceled_at: subscription.canceled_at
      ? new Date(subscription.canceled_at * 1000)
      : null,
    ended_at: subscription.ended_at
      ? new Date(subscription.ended_at * 1000)
      : null,
    synced_at: new Date(),
  });

  console.log("DEBUG: Saved subscription:", { id: savedSubscription.id, plan_id: savedSubscription.plan_id, user_uuid: savedSubscription.user_uuid });

  // Create billing activity log for subscription creation
  await BillingActivityLogs.create({
    user_uuid,
    subscription_id: savedSubscription.id,
    action_type: 'subscription_created',
    action_status: 'success',
    actor_type: 'user',
    actor_id: user_uuid,
    description: `Subscription created for plan: ${plan.name}. Status: ${subscription.status}${subscription.trial_end ? ` (Trial until ${new Date(subscription.trial_end * 1000).toISOString()})` : ''}`,
    new_value: {
      subscription_id: savedSubscription.id,
      stripe_subscription_id: subscription.id,
      plan_id: plan.id,
      status: subscription.status,
      amount: subscription.items.data[0].price.unit_amount,
      currency: subscription.items.data[0].price.currency,
    },
    metadata: {
      stripe_subscription_id: subscription.id,
      stripe_customer_id: customerId,
      price_id: priceId,
      trial_days: trialDays,
    },
  });

  console.log("Billing activity log created for subscription creation");

  // Note: Additional SubscriptionEvents are created by Laravel via Stripe webhooks
  // to maintain event history and synchronization across systems

  if (subscription.status === "trialing" && subscription.trial_end) {
    const trialEndDate = new Date(subscription.trial_end * 1000);
    const reminder24h = new Date(trialEndDate.getTime() - 24 * 60 * 60 * 1000);
    const reminder1h = new Date(trialEndDate.getTime() - 1 * 60 * 60 * 1000);

    const user = await User.findOne({ where: { uuid: user_uuid } });
  }

  await User.update({ status: "1" }, { where: { uuid: user_uuid } });

  try {
    const user = await User.findOne({ where: { uuid: user_uuid } });

    const planName = plan?.name || "Subscription";
    const isTrialing =
      subscription.status === "trialing" && subscription.trial_end;
    const actualTrialDays =
      isTrialing && subscription.trial_end && subscription.trial_start
        ? Math.round(
            (subscription.trial_end - subscription.trial_start) / 86400,
          )
        : 0;

    const isYearly =
      plan?.stripe_yearly_price_id === subscription.items.data[0].price.id;
    const price = isYearly ? plan?.yearly_price : plan?.price;
    const billingInterval = isYearly ? "year" : "month";

    emailService.initialize();

    if (user && user.email) {
      await emailService.sendWelcomeEmail({
        to: user.email,
        firstName: user.firstName,
        planName: planName,
        trialDays: actualTrialDays > 0 ? actualTrialDays : null,
        price: price,
        billingInterval: billingInterval,
        dashboardUrl: process.env.APP_URL || "https://app.insocialwise.com",
      });
      console.log(
        `Welcome email sent to ${user.email} (${isTrialing ? `${actualTrialDays}-day trial` : "direct paid"})`,
      );
    }
  } catch (emailError) {
    console.error("Error sending welcome email:", emailError.message);
  }

  return {
    success: true,
    user_uuid: user_uuid,
    subscriptionId: savedSubscription.id,
  };
};

// SECURITY: Verify subscription details by user token - returns accurate data from database
exports.verifySubscription = async (token) => {
  if (!token) {
    return { success: false, error: "Token is required" };
  }

  // Validate token format to prevent injection attacks
  if (!/^[a-f0-9\-]{36}$/.test(token)) {
    return { success: false, error: "Invalid token format" };
  }

  const user = await User.findOne({ where: { uuid: token } });
  if (!user) {
    return { success: false, error: "Invalid token" };
  }

  const subscription = await Subscriptions.findOne({
    where: { user_uuid: token },
    order: [["created_at", "DESC"]],
  });

  if (!subscription) {
    return { success: false, error: "No subscription found" };
  }

  // Try to find plan by plan_id first, then by stripe_price_id if plan_id is null
  let plan = null;
  
  if (subscription.plan_id) {
    plan = await SubscriptionPlans.findByPk(subscription.plan_id);
  }
  
  // If plan not found by ID, find by stripe_price_id or price_id (fallback for older subscriptions)
  const priceIdToCheck = subscription.stripe_price_id || subscription.price_id;
  if (!plan && priceIdToCheck) {
    plan = await SubscriptionPlans.findOne({
      where: {
        [require("sequelize").Op.or]: [
          { stripe_price_id: priceIdToCheck },
          { stripe_yearly_price_id: priceIdToCheck },
        ],
        active: 1,
      },
    });
  }

  if (!plan) {
    // Return a more helpful error message with subscription details for debugging
    console.error("Plan not found for subscription:", {
      subscriptionId: subscription.id,
      plan_id: subscription.plan_id,
      stripe_price_id: subscription.stripe_price_id,
      price_id: subscription.price_id,
    });
    return { success: false, error: "Plan information not found" };
  }
  
  // Update subscription with plan_id if it was null
  if (!subscription.plan_id && plan?.id) {
    await subscription.update({ plan_id: plan.id });
  }

  // Parse display_features
  let displayFeatures = [];
  if (plan?.display_features) {
    if (typeof plan.display_features === "string") {
      try {
        displayFeatures = JSON.parse(plan.display_features);
      } catch (e) {
        displayFeatures = [];
      }
    } else if (Array.isArray(plan.display_features)) {
      displayFeatures = plan.display_features;
    }
  }

  // SECURITY: Calculate trial status from database, not from user input
  const isTrialing = subscription.status === "trialing";
  const actualTrialDays = subscription.trial_days || 0;
  const trialStart = subscription.trial_start;
  const trialEnd = subscription.trial_end;
  
  // Calculate remaining trial days if currently trialing
  let remainingTrialDays = 0;
  if (isTrialing && trialEnd) {
    const now = new Date();
    const trialEndTime = new Date(trialEnd).getTime();
    const nowTime = now.getTime();
    remainingTrialDays = Math.ceil((trialEndTime - nowTime) / (1000 * 60 * 60 * 24));
    remainingTrialDays = Math.max(0, remainingTrialDays); // Ensure non-negative
  }

  // Determine if plan has trial capability from database
  const planHasTrial = plan.trial_enabled === 1 && plan.trial_period_days > 0;

  return {
    success: true,
    subscription: {
      id: subscription.id,
      status: subscription.status,
      isTrialing: isTrialing,
      trialDays: actualTrialDays,
      trialStart: trialStart,
      trialEnd: trialEnd,
      remainingTrialDays: remainingTrialDays,
      currentPeriodStart: subscription.current_period_start,
      currentPeriodEnd: subscription.current_period_end,
      billingInterval: subscription.billing_interval,
      amount: subscription.amount,
      currency: subscription.currency,
    },
    plan: {
      id: plan.id,
      name: plan.name,
      price: plan.price,
      yearlyPrice: plan.yearly_price,
      features: displayFeatures,
      trialEnabled: planHasTrial,
      trialPeriodDays: plan.trial_period_days,
    },
    user: {
      firstName: user.firstName,
      lastName: user.lastName,
      email: user.email,
    },
  };
};
