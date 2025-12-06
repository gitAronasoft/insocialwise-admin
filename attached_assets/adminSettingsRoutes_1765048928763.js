const express = require('express');
const router = express.Router();
const adminSettingsService = require('../services/adminSettingsService');
const AdminSettings = require('../models/mysql/AdminSettings');

router.get('/', async (req, res) => {
    try {
        const { group } = req.query;
        
        if (group) {
            const settings = adminSettingsService.getByGroup(group);
            return res.json({ success: true, data: settings });
        }
        
        const settings = adminSettingsService.getAll();
        res.json({ success: true, data: settings });
    } catch (error) {
        console.error('Error getting settings:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/groups', async (req, res) => {
    try {
        const groups = await AdminSettings.findAll({
            attributes: ['group'],
            group: ['group']
        });
        res.json({ success: true, data: groups.map(g => g.group) });
    } catch (error) {
        console.error('Error getting groups:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/email', async (req, res) => {
    try {
        const config = adminSettingsService.getEmailConfig();
        const safeConfig = {
            ...config,
            password: config.password ? '********' : null
        };
        res.json({ success: true, data: safeConfig });
    } catch (error) {
        console.error('Error getting email config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/email', async (req, res) => {
    try {
        const { host, port, secure, user, password, from, adminEmail } = req.body;
        
        const settings = [
            { key: 'email.host', value: host, type: 'string', group: 'email', description: 'SMTP Host' },
            { key: 'email.port', value: port, type: 'integer', group: 'email', description: 'SMTP Port' },
            { key: 'email.secure', value: secure, type: 'boolean', group: 'email', description: 'Use SSL/TLS' },
            { key: 'email.user', value: user, type: 'string', group: 'email', description: 'SMTP Username' },
            { key: 'email.from', value: from, type: 'email', group: 'email', description: 'From Email Address' },
            { key: 'email.admin_email', value: adminEmail, type: 'email', group: 'email', description: 'Admin Email Address' }
        ];
        
        if (password && password !== '********') {
            settings.push({ key: 'email.password', value: password, type: 'encrypted', group: 'email', description: 'SMTP Password' });
        }
        
        await adminSettingsService.setMultiple(settings);
        
        res.json({ success: true, message: 'Email settings saved successfully' });
    } catch (error) {
        console.error('Error saving email config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/stripe', async (req, res) => {
    try {
        const config = adminSettingsService.getStripeConfig();
        const safeConfig = {
            secretKey: config.secretKey ? '********' + config.secretKey.slice(-4) : null,
            webhookSecret: config.webhookSecret ? '********' : null
        };
        res.json({ success: true, data: safeConfig });
    } catch (error) {
        console.error('Error getting stripe config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/stripe', async (req, res) => {
    try {
        const { secretKey, webhookSecret } = req.body;
        
        const settings = [];
        
        if (secretKey && !secretKey.startsWith('********')) {
            settings.push({ key: 'stripe.secret_key', value: secretKey, type: 'encrypted', group: 'stripe', description: 'Stripe Secret Key' });
        }
        
        if (webhookSecret && webhookSecret !== '********') {
            settings.push({ key: 'stripe.webhook_secret', value: webhookSecret, type: 'encrypted', group: 'stripe', description: 'Stripe Webhook Secret' });
        }
        
        if (settings.length > 0) {
            await adminSettingsService.setMultiple(settings);
        }
        
        res.json({ success: true, message: 'Stripe settings saved successfully' });
    } catch (error) {
        console.error('Error saving stripe config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/webhooks', async (req, res) => {
    try {
        const config = adminSettingsService.getWebhookUrls();
        res.json({ success: true, data: config });
    } catch (error) {
        console.error('Error getting webhook config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/webhooks', async (req, res) => {
    try {
        const { n8nCommentWebhook, n8nBulkCommentWebhook, n8nKnowledgebaseWebhook, n8nUserMessageAutoReply, n8nPostCommentAutoReply } = req.body;
        
        const settings = [
            { key: 'webhook.n8n_comment', value: n8nCommentWebhook, type: 'string', group: 'webhooks', description: 'N8N Comment Webhook URL' },
            { key: 'webhook.n8n_bulk_comment', value: n8nBulkCommentWebhook, type: 'string', group: 'webhooks', description: 'N8N Bulk Comment Webhook URL' },
            { key: 'webhook.n8n_knowledgebase', value: n8nKnowledgebaseWebhook, type: 'string', group: 'webhooks', description: 'N8N Knowledgebase Webhook URL' },
            { key: 'webhook.n8n_user_message_auto_reply', value: n8nUserMessageAutoReply, type: 'string', group: 'webhooks', description: 'N8N User Message Auto Reply Webhook' },
            { key: 'webhook.n8n_post_comment_auto_reply', value: n8nPostCommentAutoReply, type: 'string', group: 'webhooks', description: 'N8N Post Comment Auto Reply Webhook' }
        ];
        
        await adminSettingsService.setMultiple(settings);
        
        res.json({ success: true, message: 'Webhook settings saved successfully' });
    } catch (error) {
        console.error('Error saving webhook config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/notification', async (req, res) => {
    try {
        const config = adminSettingsService.getNotificationConfig();
        res.json({ success: true, data: config });
    } catch (error) {
        console.error('Error getting notification config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/notification', async (req, res) => {
    try {
        const { enabled, intervalMs, trialReminder24h, trialReminder1h, renewalReminder3d, renewalReminder1d, paymentSuccessEmail, paymentFailedEmail } = req.body;
        
        const settings = [
            { key: 'notification.enabled', value: enabled, type: 'boolean', group: 'notification', description: 'Enable notification scheduler' },
            { key: 'notification.interval_ms', value: intervalMs, type: 'integer', group: 'notification', description: 'Scheduler interval in milliseconds' },
            { key: 'notification.trial_reminder_24h', value: trialReminder24h, type: 'boolean', group: 'notification', description: 'Send trial ending 24h reminder' },
            { key: 'notification.trial_reminder_1h', value: trialReminder1h, type: 'boolean', group: 'notification', description: 'Send trial ending 1h reminder' },
            { key: 'notification.renewal_reminder_3d', value: renewalReminder3d, type: 'boolean', group: 'notification', description: 'Send renewal 3 days reminder' },
            { key: 'notification.renewal_reminder_1d', value: renewalReminder1d, type: 'boolean', group: 'notification', description: 'Send renewal 1 day reminder' },
            { key: 'notification.payment_success_email', value: paymentSuccessEmail, type: 'boolean', group: 'notification', description: 'Send payment success email' },
            { key: 'notification.payment_failed_email', value: paymentFailedEmail, type: 'boolean', group: 'notification', description: 'Send payment failed email' }
        ];
        
        await adminSettingsService.setMultiple(settings);
        
        res.json({ success: true, message: 'Notification settings saved successfully' });
    } catch (error) {
        console.error('Error saving notification config:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/refresh', async (req, res) => {
    try {
        await adminSettingsService.refresh();
        res.json({ success: true, message: 'Settings cache refreshed' });
    } catch (error) {
        console.error('Error refreshing settings:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/:key', async (req, res) => {
    try {
        const { key } = req.params;
        const { value, type, group, description, section } = req.body;
        
        await adminSettingsService.set(key, value, { type, group, description, section });
        
        res.json({ success: true, message: 'Setting saved successfully' });
    } catch (error) {
        console.error('Error saving setting:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.delete('/:key', async (req, res) => {
    try {
        const { key } = req.params;
        await adminSettingsService.delete(key);
        res.json({ success: true, message: 'Setting deleted successfully' });
    } catch (error) {
        console.error('Error deleting setting:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

module.exports = router;
