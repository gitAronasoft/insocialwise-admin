<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebhookLog extends Model
{
    protected $table = 'webhook_logs';

    protected $fillable = [
        'webhook_id',
        'webhook_event_id',
        'log_level',
        'event_type',
        'stripe_event_id',
        'message',
        'context',
        'request_data',
        'response_data',
        'payload',
        'response_code',
        'response_body',
        'status',
        'error_message',
        'retry_count',
        'ip_address',
        'processing_time_ms',
        'executed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'context' => 'array',
        'request_data' => 'array',
        'response_data' => 'array',
        'executed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function webhook(): BelongsTo
    {
        return $this->belongsTo(Webhook::class);
    }

    public function webhookEvent(): BelongsTo
    {
        return $this->belongsTo(WebhookEvent::class, 'webhook_event_id');
    }

    public static function log(
        string $eventType,
        string $message,
        array $context = [],
        string $level = 'info',
        ?int $webhookEventId = null,
        ?string $stripeEventId = null,
        ?string $ipAddress = null,
        ?int $processingTimeMs = null,
        string $status = 'success'
    ): self {
        return self::create([
            'webhook_event_id' => $webhookEventId,
            'log_level' => $level,
            'event_type' => $eventType,
            'stripe_event_id' => $stripeEventId,
            'message' => $message,
            'context' => $context,
            'ip_address' => $ipAddress,
            'processing_time_ms' => $processingTimeMs,
            'status' => $status,
        ]);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'success' => 'green',
            'failed', 'error' => 'red',
            'pending' => 'yellow',
            'warning' => 'orange',
            default => 'gray',
        };
    }

    public function getLogLevelColorAttribute(): string
    {
        return match ($this->log_level ?? 'info') {
            'debug' => 'gray',
            'info' => 'blue',
            'notice' => 'cyan',
            'warning' => 'yellow',
            'error' => 'red',
            'critical' => 'red',
            'alert' => 'orange',
            'emergency' => 'red',
            default => 'gray',
        };
    }

    public function getFormattedContextAttribute(): string
    {
        return json_encode($this->context ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function toJsonLog(): array
    {
        return [
            'id' => $this->id,
            'level' => $this->log_level ?? 'info',
            'event_type' => $this->event_type,
            'stripe_event_id' => $this->stripe_event_id,
            'message' => $this->message,
            'context' => $this->context,
            'status' => $this->status,
            'processing_time_ms' => $this->processing_time_ms,
            'ip_address' => $this->ip_address,
            'timestamp' => $this->created_at?->toIso8601String(),
        ];
    }
}
