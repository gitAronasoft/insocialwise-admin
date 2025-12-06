const { Op } = require('sequelize');
const BillingNotifications = require('../models/mysql/BillingNotifications');
const Subscriptions = require('../models/mysql/Subscriptions');
const User = require('../models/mysql/User');
const SubscriptionPlans = require('../models/mysql/SubscriptionPlans');
const BillingActivityLogs = require('../models/mysql/BillingActivityLogs');
const emailService = require('./emailService');

class NotificationScheduler {
  constructor() {
    this.isRunning = false;
    this.intervalId = null;
  }

  async start(intervalMs = 60000) {
    if (this.isRunning) {
      console.log('Notification scheduler already running');
      return;
    }

    console.log('Starting notification scheduler...');
    this.isRunning = true;

    // Run initial check - wrapped in try-catch to handle missing tables gracefully
    try {
      await this.processScheduledNotifications();
      await this.scheduleUpcomingNotifications();
    } catch (error) {
      if (error.name === 'SequelizeDatabaseError' && error.parent?.code === 'ER_NO_SUCH_TABLE') {
        console.log('Notification scheduler: Billing tables not yet created, will retry on next interval');
      } else {
        console.error('Notification scheduler initial run error:', error.message);
      }
    }

    this.intervalId = setInterval(async () => {
      try {
        await this.processScheduledNotifications();
        await this.scheduleUpcomingNotifications();
      } catch (error) {
        if (error.name === 'SequelizeDatabaseError' && error.parent?.code === 'ER_NO_SUCH_TABLE') {
          // Silently skip if tables don't exist yet
        } else {
          console.error('Notification scheduler error:', error.message);
        }
      }
    }, intervalMs);

    console.log(`Notification scheduler started (interval: ${intervalMs}ms)`);
  }

  stop() {
    if (this.intervalId) {
      clearInterval(this.intervalId);
      this.intervalId = null;
    }
    this.isRunning = false;
    console.log('Notification scheduler stopped');
  }

  async processScheduledNotifications() {
    const now = new Date();

    const pendingNotifications = await BillingNotifications.findAll({
      where: {
        status: 'pending',
        scheduled_at: { [Op.lte]: now },
        retry_count: { [Op.lt]: 3 }
      },
      limit: 50,
      order: [['priority', 'DESC'], ['scheduled_at', 'ASC']]
    });

    for (const notification of pendingNotifications) {
      try {
        await this.sendNotification(notification);
      } catch (error) {
        console.error(`Error sending notification ${notification.id}:`, error);
        await notification.update({
          status: 'failed',
          retry_count: notification.retry_count + 1,
          last_error: error.message
        });
      }
    }
  }

  async sendNotification(notification) {
    await notification.update({ status: 'queued' });

    try {
      emailService.initialize();

      const templateData = notification.template_data || {};
      let emailSent = false;

      switch (notification.notification_type) {
        case 'trial_ending_24h':
          emailSent = await emailService.sendTrialEndingEmail({
            to: notification.recipient_email,
            firstName: templateData.firstName,
            planName: templateData.planName,
            trialEndDate: templateData.trialEndDate,
            hoursRemaining: 24
          });
          break;

        case 'trial_ending_1h':
          emailSent = await emailService.sendTrialEndingEmail({
            to: notification.recipient_email,
            firstName: templateData.firstName,
            planName: templateData.planName,
            trialEndDate: templateData.trialEndDate,
            hoursRemaining: 1
          });
          break;

        case 'payment_succeeded':
          emailSent = await emailService.sendPaymentSuccessEmail({
            to: notification.recipient_email,
            firstName: templateData.firstName,
            amount: templateData.amount,
            currency: templateData.currency,
            planName: templateData.planName,
            invoiceUrl: templateData.invoiceUrl
          });
          break;

        case 'payment_failed':
          emailSent = await emailService.sendPaymentFailedEmail({
            to: notification.recipient_email,
            firstName: templateData.firstName,
            amount: templateData.amount,
            currency: templateData.currency,
            failureReason: templateData.failureReason,
            nextRetry: templateData.nextRetry,
            updatePaymentUrl: templateData.updatePaymentUrl || `${process.env.APP_URL}/settings/billing`
          });
          break;

        case 'renewal_reminder_3d':
        case 'renewal_reminder_1d':
          emailSent = await emailService.sendRenewalReminderEmail({
            to: notification.recipient_email,
            firstName: templateData.firstName,
            planName: templateData.planName,
            renewalDate: templateData.renewalDate,
            amount: templateData.amount,
            currency: templateData.currency,
            daysRemaining: notification.notification_type === 'renewal_reminder_3d' ? 3 : 1
          });
          break;

        case 'subscription_canceled':
          emailSent = await emailService.sendSubscriptionCanceledEmail({
            to: notification.recipient_email,
            firstName: templateData.firstName,
            planName: templateData.planName,
            endDate: templateData.endDate
          });
          break;

        default:
          console.log(`Unknown notification type: ${notification.notification_type}`);
          emailSent = false;
      }

      if (emailSent) {
        await notification.update({
          status: 'sent',
          sent_at: new Date()
        });

        await BillingActivityLogs.create({
          user_uuid: notification.user_uuid,
          subscription_id: notification.subscription_id,
          action_type: 'notification_sent',
          action_status: 'success',
          actor_type: 'cron',
          description: `${notification.notification_type} email sent to ${notification.recipient_email}`
        });
      } else {
        throw new Error('Email sending returned false');
      }

    } catch (error) {
      await notification.update({
        status: 'failed',
        retry_count: notification.retry_count + 1,
        last_error: error.message
      });

      await BillingActivityLogs.create({
        user_uuid: notification.user_uuid,
        subscription_id: notification.subscription_id,
        action_type: 'notification_sent',
        action_status: 'failed',
        actor_type: 'cron',
        error_message: error.message,
        description: `Failed to send ${notification.notification_type} email to ${notification.recipient_email}`
      });

      throw error;
    }
  }

  async scheduleUpcomingNotifications() {
    const now = new Date();
    const in24Hours = new Date(now.getTime() + 24 * 60 * 60 * 1000);
    const in3Days = new Date(now.getTime() + 3 * 24 * 60 * 60 * 1000);

    const trialingSubscriptions = await Subscriptions.findAll({
      where: {
        status: 'trialing',
        trial_end: {
          [Op.gte]: now,
          [Op.lte]: in24Hours
        },
        trial_reminder_sent: { [Op.or]: [false, null] }
      }
    });

    for (const sub of trialingSubscriptions) {
      await this.scheduleTrialEndingNotification(sub);
    }

    const renewingSubscriptions = await Subscriptions.findAll({
      where: {
        status: 'active',
        current_period_end: {
          [Op.gte]: now,
          [Op.lte]: in3Days
        },
        renewal_reminder_sent: { [Op.or]: [false, null] }
      }
    });

    for (const sub of renewingSubscriptions) {
      await this.scheduleRenewalReminderNotification(sub);
    }
  }

  async scheduleTrialEndingNotification(subscription) {
    const existingNotification = await BillingNotifications.findOne({
      where: {
        subscription_id: subscription.id,
        notification_type: 'trial_ending_24h',
        status: { [Op.in]: ['pending', 'queued', 'sent'] }
      }
    });

    if (existingNotification) return;

    const user = await User.findOne({ where: { uuid: subscription.user_uuid } });
    const plan = await SubscriptionPlans.findByPk(subscription.plan_id);

    if (!user) return;

    const trialEndDate = new Date(subscription.trial_end);
    const reminder24h = new Date(trialEndDate.getTime() - 24 * 60 * 60 * 1000);

    if (reminder24h > new Date()) {
      await BillingNotifications.create({
        user_uuid: subscription.user_uuid,
        subscription_id: subscription.id,
        notification_type: 'trial_ending_24h',
        channel: 'email',
        priority: 'high',
        status: 'pending',
        recipient_email: user.email,
        subject: 'Your trial ends tomorrow - Add payment method',
        template_name: 'trial_ending_24h',
        template_data: {
          firstName: user.firstName,
          planName: plan?.name || 'Subscription',
          trialEndDate: trialEndDate.toISOString(),
          updatePaymentUrl: `${process.env.APP_URL}/settings/billing`
        },
        scheduled_at: reminder24h
      });

      await subscription.update({ trial_reminder_sent: true, trial_reminder_sent_at: new Date() });
    }
  }

  async scheduleRenewalReminderNotification(subscription) {
    const existingNotification = await BillingNotifications.findOne({
      where: {
        subscription_id: subscription.id,
        notification_type: { [Op.in]: ['renewal_reminder_3d', 'renewal_reminder_1d'] },
        status: { [Op.in]: ['pending', 'queued', 'sent'] }
      }
    });

    if (existingNotification) return;

    const user = await User.findOne({ where: { uuid: subscription.user_uuid } });
    const plan = await SubscriptionPlans.findByPk(subscription.plan_id);

    if (!user) return;

    const renewalDate = new Date(subscription.current_period_end);
    const now = new Date();
    const daysUntilRenewal = Math.ceil((renewalDate - now) / (24 * 60 * 60 * 1000));

    let notificationType, scheduledAt;
    if (daysUntilRenewal <= 1) {
      notificationType = 'renewal_reminder_1d';
      scheduledAt = new Date();
    } else if (daysUntilRenewal <= 3) {
      notificationType = 'renewal_reminder_3d';
      scheduledAt = new Date(renewalDate.getTime() - 3 * 24 * 60 * 60 * 1000);
    } else {
      return;
    }

    await BillingNotifications.create({
      user_uuid: subscription.user_uuid,
      subscription_id: subscription.id,
      notification_type: notificationType,
      channel: 'email',
      priority: 'normal',
      status: 'pending',
      recipient_email: user.email,
      subject: `Your subscription renews in ${daysUntilRenewal} day${daysUntilRenewal > 1 ? 's' : ''}`,
      template_name: notificationType,
      template_data: {
        firstName: user.firstName,
        planName: plan?.name || 'Subscription',
        renewalDate: renewalDate.toISOString(),
        amount: subscription.amount,
        currency: subscription.currency || 'USD'
      },
      scheduled_at: scheduledAt > now ? scheduledAt : now
    });

    await subscription.update({ renewal_reminder_sent: true, renewal_reminder_sent_at: new Date() });
  }
}

const scheduler = new NotificationScheduler();

module.exports = scheduler;
