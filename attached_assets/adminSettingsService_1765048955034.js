const crypto = require('crypto');
const AdminSettings = require('../models/mysql/AdminSettings');

class AdminSettingsService {
    constructor() {
        this.cache = new Map();
        this.isLoaded = false;
        this.encryptionKey = process.env.ENCRYPTION_SECRET || 'Aronasoft1@1@1';
    }

    encrypt(text) {
        if (!text) return text;
        const algorithm = 'aes-256-cbc';
        const key = crypto.scryptSync(this.encryptionKey, 'salt', 32);
        const iv = crypto.randomBytes(16);
        const cipher = crypto.createCipheriv(algorithm, key, iv);
        let encrypted = cipher.update(text, 'utf8', 'hex');
        encrypted += cipher.final('hex');
        return iv.toString('hex') + ':' + encrypted;
    }

    decrypt(encryptedText) {
        if (!encryptedText || !encryptedText.includes(':')) return encryptedText;
        try {
            const algorithm = 'aes-256-cbc';
            const key = crypto.scryptSync(this.encryptionKey, 'salt', 32);
            const [ivHex, encrypted] = encryptedText.split(':');
            const iv = Buffer.from(ivHex, 'hex');
            const decipher = crypto.createDecipheriv(algorithm, key, iv);
            let decrypted = decipher.update(encrypted, 'hex', 'utf8');
            decrypted += decipher.final('utf8');
            return decrypted;
        } catch (error) {
            console.error('Decryption error:', error.message);
            return encryptedText;
        }
    }

    parseValue(value, type) {
        if (value === null || value === undefined) return null;
        
        switch (type) {
            case 'integer':
                return parseInt(value, 10);
            case 'boolean':
                return value === 'true' || value === '1' || value === true;
            case 'json':
                try {
                    return JSON.parse(value);
                } catch {
                    return value;
                }
            case 'encrypted':
                return this.decrypt(value);
            default:
                return value;
        }
    }

    stringifyValue(value, type) {
        if (value === null || value === undefined) return null;
        
        switch (type) {
            case 'json':
                return typeof value === 'string' ? value : JSON.stringify(value);
            case 'encrypted':
                return this.encrypt(String(value));
            case 'boolean':
                return value ? 'true' : 'false';
            default:
                return String(value);
        }
    }

    async loadAll() {
        try {
            const settings = await AdminSettings.findAll();
            this.cache.clear();
            
            for (const setting of settings) {
                const parsedValue = this.parseValue(setting.value, setting.type);
                this.cache.set(setting.key, {
                    value: parsedValue,
                    type: setting.type,
                    group: setting.group,
                    section: setting.section,
                    description: setting.description
                });
            }
            
            this.isLoaded = true;
            console.log(`AdminSettingsService: Loaded ${settings.length} settings into cache`);
            return true;
        } catch (error) {
            if (error.name === 'SequelizeDatabaseError' && error.parent?.code === 'ER_NO_SUCH_TABLE') {
                console.log('AdminSettingsService: admin_settings table not found, using .env fallback');
            } else {
                console.error('AdminSettingsService: Error loading settings:', error.message);
            }
            this.isLoaded = true;
            return false;
        }
    }

    get(key, defaultValue = null) {
        const cached = this.cache.get(key);
        if (cached !== undefined) {
            return cached.value;
        }
        
        const envKey = key.toUpperCase().replace(/\./g, '_');
        const envValue = process.env[envKey];
        if (envValue !== undefined) {
            return envValue;
        }
        
        return defaultValue;
    }

    getByGroup(group) {
        const result = {};
        for (const [key, data] of this.cache.entries()) {
            if (data.group === group) {
                result[key] = data.value;
            }
        }
        return result;
    }

    getAll() {
        const result = {};
        for (const [key, data] of this.cache.entries()) {
            result[key] = {
                value: data.type === 'encrypted' ? '********' : data.value,
                type: data.type,
                group: data.group,
                section: data.section,
                description: data.description
            };
        }
        return result;
    }

    async set(key, value, options = {}) {
        const { type = 'string', group = 'general', description = null, section = null } = options;
        
        const storedValue = this.stringifyValue(value, type);
        
        const [setting, created] = await AdminSettings.upsert({
            key,
            value: storedValue,
            type,
            group,
            description,
            section
        });

        this.cache.set(key, {
            value: this.parseValue(storedValue, type),
            type,
            group,
            section,
            description
        });

        return { setting, created };
    }

    async setMultiple(settings) {
        const results = [];
        for (const { key, value, type, group, description, section } of settings) {
            const result = await this.set(key, value, { type, group, description, section });
            results.push(result);
        }
        return results;
    }

    async delete(key) {
        await AdminSettings.destroy({ where: { key } });
        this.cache.delete(key);
    }

    async refresh() {
        return await this.loadAll();
    }

    getEmailConfig() {
        return {
            host: this.get('email.host', process.env.EMAIL_HOST),
            port: parseInt(this.get('email.port', process.env.EMAIL_PORT) || '465', 10),
            secure: this.get('email.secure', process.env.EMAIL_SECURE) === 'true' || this.get('email.secure', process.env.EMAIL_SECURE) === true,
            user: this.get('email.user', process.env.EMAIL_USER),
            password: this.get('email.password', process.env.EMAIL_PASSWORD),
            from: this.get('email.from', process.env.EMAIL_FROM),
            adminEmail: this.get('email.admin_email', process.env.ADMIN_EMAIL)
        };
    }

    getStripeConfig() {
        return {
            secretKey: this.get('stripe.secret_key', process.env.STRIPE_SECRET_KEY),
            webhookSecret: this.get('stripe.webhook_secret', process.env.STRIPE_WEBHOOK_SECRET)
        };
    }

    getWebhookUrls() {
        return {
            n8nCommentWebhook: this.get('webhook.n8n_comment', process.env.N8N_COMMENT_WEBHOOK_URL),
            n8nBulkCommentWebhook: this.get('webhook.n8n_bulk_comment', process.env.N8N_BULK_COMMENT_WEBHOOK_URL),
            n8nKnowledgebaseWebhook: this.get('webhook.n8n_knowledgebase', process.env.N8N_KNOWLEDGEBASE_WEBHOOK_URL),
            n8nUserMessageAutoReply: this.get('webhook.n8n_user_message_auto_reply', process.env.N8N_USER_MESSAGE_AUTO_REPLY_WEBHOOK),
            n8nPostCommentAutoReply: this.get('webhook.n8n_post_comment_auto_reply', process.env.N8N_POST_COMMENT_AUTO_REPLY_WEBHOOK)
        };
    }

    getAppUrls() {
        return {
            landingSiteUrl: this.get('app.landing_site_url', process.env.LANDING_SITE_URL),
            frontendUrl: this.get('app.frontend_url', process.env.FRONTEND_URL),
            backendUrl: this.get('app.backend_url', process.env.BACKEND_URL)
        };
    }

    getNotificationConfig() {
        return {
            enabled: this.get('notification.enabled', 'true') === 'true',
            intervalMs: parseInt(this.get('notification.interval_ms', '60000'), 10),
            trialReminder24h: this.get('notification.trial_reminder_24h', 'true') === 'true',
            trialReminder1h: this.get('notification.trial_reminder_1h', 'true') === 'true',
            renewalReminder3d: this.get('notification.renewal_reminder_3d', 'true') === 'true',
            renewalReminder1d: this.get('notification.renewal_reminder_1d', 'true') === 'true',
            paymentSuccessEmail: this.get('notification.payment_success_email', 'true') === 'true',
            paymentFailedEmail: this.get('notification.payment_failed_email', 'true') === 'true'
        };
    }
}

const adminSettingsService = new AdminSettingsService();

module.exports = adminSettingsService;
