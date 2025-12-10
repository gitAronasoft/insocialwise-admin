<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder|BillingActivityLog query()
 * @method static Builder|BillingActivityLog where($column, $operator = null, $value = null)
 * @method static Builder|BillingActivityLog whereDate($column, $operator, $value = null)
 * @method static Builder|BillingActivityLog selectRaw($expression, array $bindings = [])
 * @method static int count($columns = '*')
 * @mixin Builder
 */
class BillingActivityLog extends Model
{
    protected $table = 'billing_activity_logs';

    protected $fillable = [
        'user_uuid',
        'subscription_id',
        'transaction_id',
        'action_type',
        'action_status',
        'actor_type',
        'actor_id',
        'actor_email',
        'old_value',
        'new_value',
        'amount',
        'currency',
        'stripe_event_id',
        'stripe_object_id',
        'error_code',
        'error_message',
        'description',
        'notes',
        'ip_address',
        'user_agent',
        'request_id',
        'metadata',
    ];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
        'metadata' => 'array',
        'amount' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->action_status) {
            'success' => 'green',
            'failed' => 'red',
            'pending' => 'yellow',
            'skipped' => 'gray',
            default => 'gray',
        };
    }

    public function getActionTypeIconAttribute(): string
    {
        return match ($this->action_type) {
            'subscription_created', 'subscription_updated' => 'heroicon-o-document-plus',
            'subscription_canceled' => 'heroicon-o-x-circle',
            'subscription_reactivated', 'subscription_resumed' => 'heroicon-o-arrow-path',
            'subscription_paused' => 'heroicon-o-pause-circle',
            'plan_upgraded' => 'heroicon-o-arrow-trending-up',
            'plan_downgraded' => 'heroicon-o-arrow-trending-down',
            'trial_started', 'trial_extended', 'trial_ended' => 'heroicon-o-clock',
            'payment_attempted', 'payment_succeeded' => 'heroicon-o-credit-card',
            'payment_failed' => 'heroicon-o-exclamation-triangle',
            'payment_refunded' => 'heroicon-o-arrow-uturn-left',
            'invoice_created', 'invoice_sent', 'invoice_paid', 'invoice_voided' => 'heroicon-o-document-text',
            'card_added', 'card_updated', 'card_removed', 'card_set_default' => 'heroicon-o-credit-card',
            'webhook_received', 'webhook_processed' => 'heroicon-o-arrow-path-rounded-square',
            'notification_sent' => 'heroicon-o-bell',
            'admin_action' => 'heroicon-o-user-circle',
            'system_action' => 'heroicon-o-cog-6-tooth',
            default => 'heroicon-o-information-circle',
        };
    }

    public function getActionTypeColorAttribute(): string
    {
        return match ($this->action_type) {
            'subscription_created', 'payment_succeeded', 'invoice_paid' => 'green',
            'subscription_canceled', 'payment_failed', 'trial_ended' => 'red',
            'subscription_paused', 'payment_refunded' => 'yellow',
            'plan_upgraded' => 'blue',
            'plan_downgraded' => 'orange',
            'trial_started', 'trial_extended' => 'purple',
            'webhook_received', 'webhook_processed' => 'indigo',
            default => 'gray',
        };
    }

    public function getActionTypeLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->action_type));
    }

    public function getFormattedAmountAttribute(): ?string
    {
        if (!$this->amount) {
            return null;
        }
        
        $currency = $this->currency ?? 'USD';
        $amount = $this->amount / 100;
        
        return number_format($amount, 2) . ' ' . strtoupper($currency);
    }

    public static function log(
        string $actionType,
        string $actionStatus = 'success',
        ?string $userUuid = null,
        ?int $subscriptionId = null,
        ?int $transactionId = null,
        ?string $description = null,
        array $options = []
    ): self {
        return self::create([
            'user_uuid' => $userUuid,
            'subscription_id' => $subscriptionId,
            'transaction_id' => $transactionId,
            'action_type' => $actionType,
            'action_status' => $actionStatus,
            'actor_type' => $options['actor_type'] ?? 'system',
            'actor_id' => $options['actor_id'] ?? null,
            'actor_email' => $options['actor_email'] ?? null,
            'old_value' => $options['old_value'] ?? null,
            'new_value' => $options['new_value'] ?? null,
            'amount' => $options['amount'] ?? null,
            'currency' => $options['currency'] ?? null,
            'stripe_event_id' => $options['stripe_event_id'] ?? null,
            'stripe_object_id' => $options['stripe_object_id'] ?? null,
            'error_code' => $options['error_code'] ?? null,
            'error_message' => $options['error_message'] ?? null,
            'description' => $description,
            'notes' => $options['notes'] ?? null,
            'ip_address' => $options['ip_address'] ?? request()->ip(),
            'user_agent' => $options['user_agent'] ?? request()->userAgent(),
            'request_id' => $options['request_id'] ?? null,
            'metadata' => $options['metadata'] ?? null,
        ]);
    }
}
