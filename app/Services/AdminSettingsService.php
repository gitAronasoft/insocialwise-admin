<?php

namespace App\Services;

use App\Models\AdminSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class AdminSettingsService
{
    protected const CACHE_PREFIX = 'admin_settings:';
    protected const CACHE_TTL = 3600;

    public function get(string $key, $default = null)
    {
        $cacheKey = self::CACHE_PREFIX . $key;
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($key, $default) {
            return AdminSetting::getValue($key, $default);
        });
    }

    public function set(
        string $key, 
        $value, 
        string $type = AdminSetting::TYPE_STRING, 
        string $group = AdminSetting::GROUP_GENERAL,
        ?string $description = null,
        ?string $section = null
    ): void {
        AdminSetting::setValue($key, $value, $type, $group, $description, $section);
        $this->clearCache($key);
    }

    public function delete(string $key): bool
    {
        $result = AdminSetting::where('key', $key)->delete() > 0;
        $this->clearCache($key);
        return $result;
    }

    public function clearCache(?string $key = null): void
    {
        if ($key) {
            Cache::forget(self::CACHE_PREFIX . $key);
        } else {
            $settings = AdminSetting::pluck('key');
            foreach ($settings as $settingKey) {
                Cache::forget(self::CACHE_PREFIX . $settingKey);
            }
            Cache::forget(self::CACHE_PREFIX . 'grouped');
        }
    }

    public function getByGroup(string $group): array
    {
        $cacheKey = self::CACHE_PREFIX . 'group:' . $group;
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($group) {
            return AdminSetting::getByGroup($group);
        });
    }

    public function getGroupedSettings(): array
    {
        $cacheKey = self::CACHE_PREFIX . 'grouped';
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return AdminSetting::getGroupedSettings();
        });
    }

    public function getEmailConfig(): array
    {
        $cacheKey = self::CACHE_PREFIX . 'config:email';
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return AdminSetting::getEmailConfig();
        });
    }

    public function getStripeConfig(): array
    {
        $cacheKey = self::CACHE_PREFIX . 'config:stripe';
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return AdminSetting::getStripeConfig();
        });
    }

    public function getWebhookUrls(): array
    {
        $cacheKey = self::CACHE_PREFIX . 'config:webhooks';
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return AdminSetting::getWebhookUrls();
        });
    }

    public function getNotificationConfig(): array
    {
        $cacheKey = self::CACHE_PREFIX . 'config:notification';
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return AdminSetting::getNotificationConfig();
        });
    }

    public function updateEmailConfig(array $config): void
    {
        $fields = [
            'smtp_host' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'SMTP server hostname'],
            'smtp_port' => ['type' => AdminSetting::TYPE_INTEGER, 'desc' => 'SMTP server port'],
            'smtp_username' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'SMTP username'],
            'smtp_password' => ['type' => AdminSetting::TYPE_ENCRYPTED, 'desc' => 'SMTP password (encrypted)'],
            'smtp_encryption' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'SMTP encryption (tls/ssl)'],
            'from_address' => ['type' => AdminSetting::TYPE_EMAIL, 'desc' => 'Default from email address'],
            'from_name' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'Default from name'],
        ];

        foreach ($config as $key => $value) {
            if (isset($fields[$key]) && $value !== null) {
                if ($key === 'smtp_password' && $value === '') {
                    continue;
                }
                
                $this->set(
                    $key,
                    $value,
                    $fields[$key]['type'],
                    AdminSetting::GROUP_EMAIL,
                    $fields[$key]['desc'],
                    'smtp'
                );
            }
        }

        Cache::forget(self::CACHE_PREFIX . 'config:email');
        Cache::forget(self::CACHE_PREFIX . 'group:' . AdminSetting::GROUP_EMAIL);
    }

    public function updateStripeConfig(array $config): void
    {
        $fields = [
            'stripe_publishable_key' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'Stripe publishable key'],
            'stripe_secret_key' => ['type' => AdminSetting::TYPE_ENCRYPTED, 'desc' => 'Stripe secret key (encrypted)'],
            'stripe_webhook_secret' => ['type' => AdminSetting::TYPE_ENCRYPTED, 'desc' => 'Stripe webhook secret (encrypted)'],
            'stripe_mode' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'Stripe mode (test/live)'],
        ];

        foreach ($config as $key => $value) {
            if (isset($fields[$key]) && $value !== null) {
                if (($key === 'stripe_secret_key' || $key === 'stripe_webhook_secret') && $value === '') {
                    continue;
                }
                
                $this->set(
                    $key,
                    $value,
                    $fields[$key]['type'],
                    AdminSetting::GROUP_STRIPE,
                    $fields[$key]['desc'],
                    'api'
                );
            }
        }

        Cache::forget(self::CACHE_PREFIX . 'config:stripe');
        Cache::forget(self::CACHE_PREFIX . 'group:' . AdminSetting::GROUP_STRIPE);
    }

    public function updateWebhookUrls(array $config): void
    {
        $fields = [
            'n8n_webhook_url' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'N8N webhook URL'],
            'zapier_webhook_url' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'Zapier webhook URL'],
            'custom_webhook_url' => ['type' => AdminSetting::TYPE_STRING, 'desc' => 'Custom webhook URL'],
            'webhook_secret' => ['type' => AdminSetting::TYPE_ENCRYPTED, 'desc' => 'Webhook signing secret'],
        ];

        foreach ($config as $key => $value) {
            if (isset($fields[$key])) {
                $this->set(
                    $key,
                    $value ?? '',
                    $fields[$key]['type'],
                    AdminSetting::GROUP_WEBHOOKS,
                    $fields[$key]['desc'],
                    'integrations'
                );
            }
        }

        Cache::forget(self::CACHE_PREFIX . 'config:webhooks');
        Cache::forget(self::CACHE_PREFIX . 'group:' . AdminSetting::GROUP_WEBHOOKS);
    }

    public function updateNotificationConfig(array $config): void
    {
        $fields = [
            'trial_reminder_enabled' => ['type' => AdminSetting::TYPE_BOOLEAN, 'desc' => 'Enable trial ending reminders'],
            'trial_reminder_hours' => ['type' => AdminSetting::TYPE_INTEGER, 'desc' => 'Hours before trial ends to send reminder'],
            'renewal_reminder_enabled' => ['type' => AdminSetting::TYPE_BOOLEAN, 'desc' => 'Enable renewal reminders'],
            'renewal_reminder_days' => ['type' => AdminSetting::TYPE_INTEGER, 'desc' => 'Days before renewal to send reminder'],
            'payment_success_email' => ['type' => AdminSetting::TYPE_BOOLEAN, 'desc' => 'Send email on successful payment'],
            'payment_failed_email' => ['type' => AdminSetting::TYPE_BOOLEAN, 'desc' => 'Send email on failed payment'],
            'subscription_created_email' => ['type' => AdminSetting::TYPE_BOOLEAN, 'desc' => 'Send email when subscription created'],
            'subscription_canceled_email' => ['type' => AdminSetting::TYPE_BOOLEAN, 'desc' => 'Send email when subscription canceled'],
        ];

        foreach ($config as $key => $value) {
            if (isset($fields[$key])) {
                $this->set(
                    $key,
                    $value,
                    $fields[$key]['type'],
                    AdminSetting::GROUP_NOTIFICATION,
                    $fields[$key]['desc'],
                    'billing'
                );
            }
        }

        Cache::forget(self::CACHE_PREFIX . 'config:notification');
        Cache::forget(self::CACHE_PREFIX . 'group:' . AdminSetting::GROUP_NOTIFICATION);
    }

    public function testSmtpConnection(): array
    {
        $config = $this->getEmailConfig();
        
        try {
            $transport = new \Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport(
                $config['smtp_host'] ?? 'localhost',
                (int) ($config['smtp_port'] ?? 587),
                ($config['smtp_encryption'] ?? 'tls') === 'ssl'
            );
            
            if (!empty($config['smtp_username']) && !empty($config['smtp_password'])) {
                $transport->setUsername($config['smtp_username']);
                $transport->setPassword($config['smtp_password']);
            }
            
            return [
                'success' => true,
                'message' => 'SMTP configuration is valid.',
            ];
        } catch (\Exception $e) {
            Log::error('SMTP test failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'SMTP test failed: ' . $e->getMessage(),
            ];
        }
    }

    public function testStripeConnection(): array
    {
        $config = $this->getStripeConfig();
        
        $secretKey = $config['stripe_secret_key'] ?? null;
        if (!$secretKey) {
            return [
                'success' => false,
                'message' => 'Stripe secret key is not configured.',
            ];
        }
        
        try {
            $stripe = new \Stripe\StripeClient($secretKey);
            $account = $stripe->accounts->retrieve();
            
            return [
                'success' => true,
                'message' => 'Stripe connection successful.',
                'data' => [
                    'account_id' => $account->id,
                    'country' => $account->country,
                    'charges_enabled' => $account->charges_enabled,
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Stripe test failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Stripe test failed: ' . $e->getMessage(),
            ];
        }
    }

    public function seedDefaultSettings(): void
    {
        $defaults = [
            ['key' => 'trial_reminder_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Enable trial ending reminders'],
            ['key' => 'trial_reminder_hours', 'value' => '24', 'type' => 'integer', 'group' => 'notification', 'description' => 'Hours before trial ends to send reminder'],
            ['key' => 'renewal_reminder_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Enable renewal reminders'],
            ['key' => 'renewal_reminder_days', 'value' => '7', 'type' => 'integer', 'group' => 'notification', 'description' => 'Days before renewal to send reminder'],
            ['key' => 'payment_success_email', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Send email on successful payment'],
            ['key' => 'payment_failed_email', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Send email on failed payment'],
            ['key' => 'subscription_created_email', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Send email when subscription created'],
            ['key' => 'subscription_canceled_email', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Send email when subscription canceled'],
        ];

        foreach ($defaults as $setting) {
            AdminSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->clearCache();
    }
}
