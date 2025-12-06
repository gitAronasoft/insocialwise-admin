<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class AdminSetting extends Model
{
    protected $table = 'admin_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'section',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_JSON = 'json';
    const TYPE_EMAIL = 'email';
    const TYPE_ENCRYPTED = 'encrypted';

    const GROUP_GENERAL = 'general';
    const GROUP_EMAIL = 'email';
    const GROUP_STRIPE = 'stripe';
    const GROUP_WEBHOOKS = 'webhooks';
    const GROUP_NOTIFICATION = 'notification';

    public function getTypedValueAttribute()
    {
        $value = $this->value;
        
        if ($this->type === self::TYPE_ENCRYPTED && $value) {
            try {
                $value = Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        
        return match ($this->type) {
            self::TYPE_BOOLEAN => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            self::TYPE_INTEGER => (int) $value,
            self::TYPE_JSON => is_string($value) ? json_decode($value, true) : $value,
            default => $value,
        };
    }

    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        return $setting->typed_value ?? $default;
    }

    public static function setValue(
        string $key, 
        $value, 
        string $type = self::TYPE_STRING, 
        string $group = self::GROUP_GENERAL, 
        ?string $description = null,
        ?string $section = null
    ): void {
        if (is_array($value) && $type !== self::TYPE_JSON) {
            $value = json_encode($value);
            $type = self::TYPE_JSON;
        }
        
        if ($type === self::TYPE_ENCRYPTED && $value) {
            $value = Crypt::encryptString((string) $value);
        } elseif ($type === self::TYPE_JSON && is_array($value)) {
            $value = json_encode($value);
        } elseif ($type === self::TYPE_BOOLEAN) {
            $value = $value ? '1' : '0';
        }

        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string) $value, 
                'type' => $type, 
                'group' => $group, 
                'description' => $description,
                'section' => $section,
            ]
        );
    }

    public static function getByGroup(string $group): array
    {
        $settings = static::where('group', $group)->get();
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->typed_value;
        }
        
        return $result;
    }

    public static function getEmailConfig(): array
    {
        $defaults = [
            'smtp_host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
            'smtp_port' => env('MAIL_PORT', 587),
            'smtp_username' => env('MAIL_USERNAME'),
            'smtp_password' => env('MAIL_PASSWORD'),
            'smtp_encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@insocialwise.com'),
            'from_name' => env('MAIL_FROM_NAME', 'InSocialWise'),
        ];
        
        $dbSettings = static::getByGroup(self::GROUP_EMAIL);
        
        return array_merge($defaults, $dbSettings);
    }

    public static function getStripeConfig(): array
    {
        $defaults = [
            'stripe_publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
            'stripe_secret_key' => env('STRIPE_SECRET_KEY'),
            'stripe_webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            'stripe_mode' => env('STRIPE_MODE', 'test'),
        ];
        
        $dbSettings = static::getByGroup(self::GROUP_STRIPE);
        
        return array_merge($defaults, $dbSettings);
    }

    public static function getWebhookUrls(): array
    {
        $defaults = [
            'n8n_webhook_url' => env('N8N_WEBHOOK_URL'),
            'zapier_webhook_url' => env('ZAPIER_WEBHOOK_URL'),
            'custom_webhook_url' => env('CUSTOM_WEBHOOK_URL'),
        ];
        
        $dbSettings = static::getByGroup(self::GROUP_WEBHOOKS);
        
        return array_merge($defaults, $dbSettings);
    }

    public static function getNotificationConfig(): array
    {
        $defaults = [
            'trial_reminder_enabled' => true,
            'trial_reminder_hours' => 24,
            'renewal_reminder_enabled' => true,
            'renewal_reminder_days' => 7,
            'payment_success_email' => true,
            'payment_failed_email' => true,
            'subscription_created_email' => true,
            'subscription_canceled_email' => true,
        ];
        
        $dbSettings = static::getByGroup(self::GROUP_NOTIFICATION);
        
        foreach ($dbSettings as $key => $value) {
            if (is_string($value) && in_array($value, ['0', '1', 'true', 'false'])) {
                $dbSettings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }
        
        return array_merge($defaults, $dbSettings);
    }

    public function isEncrypted(): bool
    {
        return $this->type === self::TYPE_ENCRYPTED;
    }

    public function getMaskedValueAttribute(): string
    {
        if ($this->type === self::TYPE_ENCRYPTED) {
            $decrypted = $this->typed_value;
            if ($decrypted && strlen($decrypted) > 8) {
                return substr($decrypted, 0, 4) . str_repeat('*', strlen($decrypted) - 8) . substr($decrypted, -4);
            }
            return '••••••••';
        }
        
        return $this->value ?? '';
    }

    public static function getGroupedSettings(): array
    {
        $settings = static::all()->groupBy('group');
        $result = [];
        
        foreach ($settings as $group => $items) {
            $result[$group] = [];
            foreach ($items as $item) {
                $result[$group][$item->key] = [
                    'value' => $item->typed_value,
                    'type' => $item->type,
                    'description' => $item->description,
                    'section' => $item->section,
                ];
            }
        }
        
        return $result;
    }
}
