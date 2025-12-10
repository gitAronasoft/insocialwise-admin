<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $casts = [
        'payload' => 'array',
        'actions_taken' => 'array',
        'affected_records' => 'array',
        'livemode' => 'boolean',
        'signature_verified' => 'boolean',
        'retry_count' => 'integer',
        'response_code' => 'integer',
        'processing_time_ms' => 'integer',
        'received_at' => 'datetime',
        'processed_at' => 'datetime',
        'executed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function webhook(): BelongsTo
    {
        return $this->belongsTo(Webhook::class, 'webhook_id');
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'processed', 'success' => 'green',
            'pending', 'processing' => 'yellow',
            'failed' => 'red',
            'skipped' => 'gray',
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
}
