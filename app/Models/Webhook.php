<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Webhook extends Model
{
    protected $table = 'webhooks';

    protected $fillable = [
        'name',
        'provider',
        'event_type',
        'endpoint_url',
        'secret',
        'active',
        'last_triggered_at',
        'last_status',
        'last_response',
        'success_count',
        'failure_count',
    ];

    protected $casts = [
        'active' => 'boolean',
        'last_triggered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = ['secret'];

    public function setSecretAttribute($value)
    {
        if ($value) {
            $this->attributes['secret'] = Crypt::encryptString($value);
        }
    }

    public function getDecryptedSecretAttribute(): ?string
    {
        if ($this->attributes['secret']) {
            try {
                return Crypt::decryptString($this->attributes['secret']);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    public function getMaskedSecretAttribute(): string
    {
        $secret = $this->decrypted_secret;
        if (!$secret) return '••••••••';
        
        $length = strlen($secret);
        if ($length <= 8) {
            return str_repeat('•', $length);
        }
        
        return str_repeat('•', $length - 4) . substr($secret, -4);
    }

    public function logs()
    {
        return $this->hasMany(WebhookLog::class);
    }

    public function getSuccessRateAttribute(): float
    {
        $total = $this->success_count + $this->failure_count;
        if ($total === 0) return 0;
        
        return round(($this->success_count / $total) * 100, 1);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->last_status) {
            'success' => 'green',
            'failed' => 'red',
            'pending' => 'yellow',
            default => 'gray',
        };
    }

    public function getProviderIconAttribute(): string
    {
        return match ($this->provider) {
            'stripe' => 'credit-card',
            'facebook' => 'facebook',
            'linkedin' => 'linkedin',
            'n8n' => 'cog',
            default => 'link',
        };
    }
}
