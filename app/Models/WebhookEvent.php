<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebhookEvent extends Model
{
    protected $table = 'webhook_events';

    protected $fillable = [
        'webhook_id',
        'stripe_event_id',
        'api_version',
        'livemode',
        'object_type',
        'object_id',
        'customer_id',
        'subscription_id',
        'invoice_id',
        'payment_intent_id',
        'event_type',
        'payload',
        'payload_hash',
        'response_code',
        'response_body',
        'status',
        'error_message',
        'retry_count',
        'received_at',
        'processed_at',
        'processing_time_ms',
        'executed_at',
        'ip_address',
        'signature_verified',
        'actions_taken',
        'affected_records',
        'request_headers',
        'response_data',
    ];

    protected $casts = [
        'payload' => 'array',
        'actions_taken' => 'array',
        'affected_records' => 'array',
        'request_headers' => 'array',
        'response_data' => 'array',
        'retry_count' => 'integer',
        'response_code' => 'integer',
        'processing_time_ms' => 'integer',
        'received_at' => 'datetime',
        'processed_at' => 'datetime',
        'executed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function setLivemodeAttribute($value)
    {
        $this->attributes['livemode'] = $value === true || $value === 1 || $value === '1' ? 'true' : 'false';
    }

    public function getLivemodeAttribute($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function setSignatureVerifiedAttribute($value)
    {
        $this->attributes['signature_verified'] = $value === true || $value === 1 || $value === '1' ? 'true' : 'false';
    }

    public function getSignatureVerifiedAttribute($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function webhook(): BelongsTo
    {
        return $this->belongsTo(Webhook::class, 'webhook_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(WebhookLog::class, 'webhook_event_id');
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'processed', 'success' => 'green',
            'received', 'processing' => 'yellow',
            'failed' => 'red',
            'skipped' => 'gray',
            'retrying' => 'blue',
            default => 'gray',
        };
    }

    public function getEventTypeIconAttribute(): string
    {
        return match (true) {
            str_contains($this->event_type, 'subscription') => 'heroicon-o-arrow-path',
            str_contains($this->event_type, 'invoice') => 'heroicon-o-document-text',
            str_contains($this->event_type, 'payment') => 'heroicon-o-credit-card',
            str_contains($this->event_type, 'charge') => 'heroicon-o-banknotes',
            str_contains($this->event_type, 'customer') => 'heroicon-o-user',
            default => 'heroicon-o-bell',
        };
    }

    public function getEventTypeColorAttribute(): string
    {
        return match (true) {
            str_contains($this->event_type, 'created') => 'green',
            str_contains($this->event_type, 'updated') => 'blue',
            str_contains($this->event_type, 'deleted') => 'red',
            str_contains($this->event_type, 'succeeded') => 'green',
            str_contains($this->event_type, 'failed') => 'red',
            str_contains($this->event_type, 'refunded') => 'orange',
            default => 'gray',
        };
    }

    public function isProcessed(): bool
    {
        return $this->status === 'processed' || $this->status === 'success';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending' || $this->status === 'processing';
    }

    public function toJsonLog(): array
    {
        return [
            'id' => $this->id,
            'stripe_event_id' => $this->stripe_event_id,
            'event_type' => $this->event_type,
            'api_version' => $this->api_version,
            'livemode' => $this->livemode,
            'status' => $this->status,
            'object' => [
                'type' => $this->object_type,
                'id' => $this->object_id,
            ],
            'related' => [
                'customer_id' => $this->customer_id,
                'subscription_id' => $this->subscription_id,
                'invoice_id' => $this->invoice_id,
                'payment_intent_id' => $this->payment_intent_id,
            ],
            'processing' => [
                'received_at' => $this->received_at?->toIso8601String(),
                'processed_at' => $this->processed_at?->toIso8601String(),
                'processing_time_ms' => $this->processing_time_ms,
                'actions_taken' => $this->actions_taken,
                'affected_records' => $this->affected_records,
            ],
            'signature_verified' => $this->signature_verified,
            'ip_address' => $this->ip_address,
            'error_message' => $this->error_message,
            'payload' => $this->payload,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }

    public function getFormattedPayloadAttribute(): string
    {
        return json_encode($this->payload ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
