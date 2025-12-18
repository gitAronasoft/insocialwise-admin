<?php

namespace App\Services;

use App\Models\BillingActivityLog;
use App\Models\BillingNotification;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Subscription;
use App\Models\SubscriptionEvent;
use App\Models\Transaction;
use App\Models\WebhookEvent;
use Illuminate\Support\Facades\Log;
use Stripe\Event;

class StripeWebhookService
{
    protected ?\Stripe\StripeClient $stripe;

    public function __construct()
    {
        $secretKey = config('services.stripe.secret');
        $this->stripe = $secretKey ? new \Stripe\StripeClient($secretKey) : null;
    }

    public function processEvent(Event $event, ?string $ipAddress = null, float $startTime = 0): array
    {
        $existingEvent = WebhookEvent::where('stripe_event_id', $event->id)->first();
        if ($existingEvent) {
            Log::info("Webhook event {$event->id} already processed, skipping");
            return ['success' => true, 'status' => 'already_processed'];
        }

        $payloadHash = hash('sha256', json_encode($event->toArray()));

        $webhookEvent = WebhookEvent::create([
            'stripe_event_id' => $event->id,
            'event_type' => $event->type,
            'api_version' => $event->api_version,
            'livemode' => $event->livemode,
            'object_type' => $event->data->object->object ?? null,
            'object_id' => $event->data->object->id ?? null,
            'customer_id' => $event->data->object->customer ?? null,
            'subscription_id' => $event->data->object->subscription ?? (str_contains($event->type, 'subscription') ? ($event->data->object->id ?? null) : null),
            'invoice_id' => str_contains($event->type, 'invoice') ? ($event->data->object->id ?? null) : ($event->data->object->invoice ?? null),
            'payment_intent_id' => $event->data->object->payment_intent ?? null,
            'payload' => $event->toArray(),
            'payload_hash' => $payloadHash,
            'status' => 'processing',
            'received_at' => now(),
            'ip_address' => $ipAddress,
            'signature_verified' => true,
        ]);

        Log::info("Processing Stripe webhook: {$event->type} ({$event->id})");

        $actionsTaken = [];
        $affectedRecords = [];
        $errorOccurred = null;

        try {
            switch ($event->type) {
                case 'customer.subscription.created':
                    $result = $this->handleSubscriptionCreated($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'customer.subscription.updated':
                    $result = $this->handleSubscriptionUpdated($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'customer.subscription.deleted':
                    $result = $this->handleSubscriptionDeleted($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'invoice.created':
                    $result = $this->handleInvoiceCreated($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'invoice.payment_succeeded':
                    $result = $this->handleInvoicePaymentSucceeded($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'invoice.payment_failed':
                    $result = $this->handleInvoicePaymentFailed($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'charge.refunded':
                    $result = $this->handleChargeRefunded($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'payment_method.attached':
                    $result = $this->handlePaymentMethodAttached($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                case 'payment_method.detached':
                    $result = $this->handlePaymentMethodDetached($event);
                    $actionsTaken = array_merge($actionsTaken, $result['actions']);
                    $affectedRecords = array_merge($affectedRecords, $result['affected']);
                    break;

                default:
                    $actionsTaken[] = 'event_logged';
                    break;
            }
        } catch (\Exception $e) {
            $errorOccurred = $e->getMessage();
            Log::error("Webhook processing error for {$event->type}: " . $e->getMessage());
        }

        $processingTimeMs = (int) ((microtime(true) - $startTime) * 1000);

        $webhookEvent->update([
            'status' => $errorOccurred ? 'failed' : 'processed',
            'error_message' => $errorOccurred,
            'processed_at' => now(),
            'processing_time_ms' => $processingTimeMs,
            'actions_taken' => $actionsTaken,
            'affected_records' => $affectedRecords,
        ]);

        return [
            'success' => !$errorOccurred,
            'status' => $errorOccurred ? 'failed' : 'processed',
            'error' => $errorOccurred,
            'actions' => $actionsTaken,
            'affected' => $affectedRecords,
        ];
    }

    protected function handleSubscriptionCreated(Event $event): array
    {
        $subscription = $event->data->object;
        $customerId = $subscription->customer;

        $customer = Customer::where('stripe_customer_id', $customerId)->first();

        if (!$customer) {
            return ['actions' => ['customer_not_found_for_subscription'], 'affected' => []];
        }

        $stripePriceId = $subscription->items->data[0]->price->id ?? null;
        
        $existingSub = Subscription::where('stripe_subscription_id', $subscription->id)->first();
        
        $planId = $existingSub?->plan_id;
        if (!$planId && $stripePriceId) {
            $plan = \App\Models\SubscriptionPlan::where('stripe_price_id', $stripePriceId)
                ->orWhere('stripe_yearly_price_id', $stripePriceId)
                ->first();
            $planId = $plan?->id;
        }

        $sub = Subscription::updateOrCreate(
            ['stripe_subscription_id' => $subscription->id],
            [
                'user_uuid' => $customer->uuid,
                'stripe_customer_id' => $customerId,
                'stripe_price_id' => $stripePriceId,
                'plan_id' => $planId ?? $existingSub?->plan_id,
                'status' => $subscription->status,
                'current_period_start' => $subscription->current_period_start ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_start) : null,
                'current_period_end' => $subscription->current_period_end ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) : null,
                'billing_cycle_anchor' => $subscription->billing_cycle_anchor ? \Carbon\Carbon::createFromTimestamp($subscription->billing_cycle_anchor) : null,
                'next_invoice_date' => $subscription->current_period_end ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) : null,
                'cancel_at_period_end' => $subscription->cancel_at_period_end ?? false,
                'cancel_at' => $subscription->cancel_at ? \Carbon\Carbon::createFromTimestamp($subscription->cancel_at) : null,
                'canceled_at' => $subscription->canceled_at ? \Carbon\Carbon::createFromTimestamp($subscription->canceled_at) : null,
                'trial_start' => $subscription->trial_start ? \Carbon\Carbon::createFromTimestamp($subscription->trial_start) : null,
                'trial_end' => $subscription->trial_end ? \Carbon\Carbon::createFromTimestamp($subscription->trial_end) : null,
                'trial_days' => $subscription->trial_end && $subscription->trial_start 
                    ? (int) round(($subscription->trial_end - $subscription->trial_start) / 86400) 
                    : null,
                'amount' => $subscription->items->data[0]->price->unit_amount ?? 0,
                'currency' => strtoupper($subscription->currency ?? 'USD'),
                'billing_interval' => $subscription->items->data[0]->price->recurring->interval ?? 'month',
                'quantity' => $subscription->items->data[0]->quantity ?? 1,
                'collection_method' => $subscription->collection_method ?? null,
                'latest_invoice_id' => $subscription->latest_invoice,
                'default_payment_method_id' => $subscription->default_payment_method,
                'metadata' => (array) ($subscription->metadata ?? []),
                'synced_at' => now(),
            ]
        );

        $wasRecentlyCreated = $sub->wasRecentlyCreated;
        $eventType = $wasRecentlyCreated ? 'subscription_created' : 'subscription_synced';
        $action = $wasRecentlyCreated ? 'subscription_created' : 'subscription_synced';

        SubscriptionEvent::create([
            'subscription_id' => $sub->id,
            'user_uuid' => $customer->uuid,
            'stripe_subscription_id' => $subscription->id,
            'stripe_event_id' => $event->id,
            'event_type' => $eventType,
            'new_status' => $subscription->status,
            'amount' => $subscription->items->data[0]->price->unit_amount ?? 0,
            'currency' => strtoupper($subscription->currency ?? 'USD'),
            'actor' => 'stripe',
            'actor_id' => 'webhook',
            'description' => $wasRecentlyCreated 
                ? 'New subscription created via webhook' 
                : 'Subscription data synced from Stripe webhook',
            'event_payload' => (array) $event->data->object,
            'occurred_at' => \Carbon\Carbon::createFromTimestamp($event->created),
            'processed_at' => now(),
        ]);

        BillingActivityLog::log(
            $eventType,
            'success',
            $customer->uuid,
            $sub->id,
            null,
            $wasRecentlyCreated 
                ? 'New subscription created: ' . $subscription->id 
                : 'Subscription synced from Stripe: ' . $subscription->id,
            [
                'actor_type' => 'stripe',
                'new_value' => ['status' => $subscription->status, 'amount' => $subscription->items->data[0]->price->unit_amount ?? 0],
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $subscription->id,
            ]
        );

        return [
            'actions' => [$action],
            'affected' => [['type' => 'subscription', 'id' => $sub->id]],
        ];
    }

    protected function handleSubscriptionUpdated(Event $event): array
    {
        $subscription = $event->data->object;
        $previousAttributes = $event->data->previous_attributes ?? [];

        $sub = Subscription::where('stripe_subscription_id', $subscription->id)->first();

        if (!$sub) {
            return ['actions' => ['subscription_not_found'], 'affected' => []];
        }

        $oldStatus = $sub->status;
        
        $stripePriceId = $subscription->items->data[0]->price->id ?? null;
        $planId = $sub->plan_id;
        if (!$planId && $stripePriceId) {
            $plan = \App\Models\SubscriptionPlan::where('stripe_price_id', $stripePriceId)
                ->orWhere('stripe_yearly_price_id', $stripePriceId)
                ->first();
            if ($plan) {
                $planId = $plan->id;
            }
        }
        
        $updates = [
            'status' => $subscription->status,
            'stripe_price_id' => $stripePriceId ?? $sub->stripe_price_id,
            'plan_id' => $planId,
            'current_period_start' => $subscription->current_period_start ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_start) : null,
            'current_period_end' => $subscription->current_period_end ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) : null,
            'billing_cycle_anchor' => $subscription->billing_cycle_anchor ? \Carbon\Carbon::createFromTimestamp($subscription->billing_cycle_anchor) : $sub->billing_cycle_anchor,
            'next_invoice_date' => $subscription->current_period_end ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) : null,
            'cancel_at_period_end' => $subscription->cancel_at_period_end,
            'cancel_at' => $subscription->cancel_at ? \Carbon\Carbon::createFromTimestamp($subscription->cancel_at) : null,
            'canceled_at' => $subscription->canceled_at ? \Carbon\Carbon::createFromTimestamp($subscription->canceled_at) : null,
            'ended_at' => $subscription->ended_at ? \Carbon\Carbon::createFromTimestamp($subscription->ended_at) : null,
            'trial_start' => $subscription->trial_start ? \Carbon\Carbon::createFromTimestamp($subscription->trial_start) : $sub->trial_start,
            'trial_end' => $subscription->trial_end ? \Carbon\Carbon::createFromTimestamp($subscription->trial_end) : $sub->trial_end,
            'trial_days' => $subscription->trial_end && $subscription->trial_start 
                ? (int) round(($subscription->trial_end - $subscription->trial_start) / 86400) 
                : $sub->trial_days,
            'amount' => $subscription->items->data[0]->price->unit_amount ?? $sub->amount,
            'currency' => strtoupper($subscription->currency ?? $sub->currency ?? 'USD'),
            'billing_interval' => $subscription->items->data[0]->price->recurring->interval ?? $sub->billing_interval ?? 'month',
            'quantity' => $subscription->items->data[0]->quantity ?? $sub->quantity ?? 1,
            'collection_method' => $subscription->collection_method ?? $sub->collection_method,
            'latest_invoice_id' => $subscription->latest_invoice,
            'default_payment_method_id' => $subscription->default_payment_method ?? $sub->default_payment_method_id,
            'synced_at' => now(),
        ];

        if ($subscription->status === 'past_due' && $oldStatus !== 'past_due') {
            $updates['past_due_since'] = now();
            $updates['dunning_status'] = 'in_progress';
        }

        if ($subscription->status === 'active' && $oldStatus === 'past_due') {
            $updates['past_due_since'] = null;
            $updates['dunning_status'] = 'none';
            $updates['payment_retry_count'] = 0;
        }

        $sub->update($updates);

        SubscriptionEvent::create([
            'subscription_id' => $sub->id,
            'user_uuid' => $sub->user_uuid,
            'stripe_subscription_id' => $subscription->id,
            'stripe_event_id' => $event->id,
            'event_type' => $oldStatus !== $subscription->status ? 'status_changed' : 'subscription_updated',
            'old_status' => $oldStatus,
            'new_status' => $subscription->status,
            'actor' => 'stripe',
            'actor_id' => 'webhook',
            'description' => "Subscription updated: {$oldStatus} → {$subscription->status}",
            'metadata' => (array) $previousAttributes,
            'event_payload' => (array) $event->data->object,
            'occurred_at' => \Carbon\Carbon::createFromTimestamp($event->created),
            'processed_at' => now(),
        ]);

        BillingActivityLog::log(
            'subscription_updated',
            'success',
            $sub->user_uuid,
            $sub->id,
            null,
            "Subscription status changed from {$oldStatus} to {$subscription->status}",
            [
                'actor_type' => 'stripe',
                'old_value' => ['status' => $oldStatus],
                'new_value' => ['status' => $subscription->status],
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $subscription->id,
            ]
        );

        return [
            'actions' => ['subscription_updated'],
            'affected' => [['type' => 'subscription', 'id' => $sub->id]],
        ];
    }

    protected function handleSubscriptionDeleted(Event $event): array
    {
        $subscription = $event->data->object;

        $sub = Subscription::where('stripe_subscription_id', $subscription->id)->first();

        if (!$sub) {
            return ['actions' => ['subscription_not_found'], 'affected' => []];
        }

        $oldStatus = $sub->status;

        $sub->update([
            'status' => 'canceled',
            'ended_at' => now(),
            'canceled_at' => $subscription->canceled_at ? \Carbon\Carbon::createFromTimestamp($subscription->canceled_at) : now(),
            'synced_at' => now(),
        ]);

        SubscriptionEvent::create([
            'subscription_id' => $sub->id,
            'user_uuid' => $sub->user_uuid,
            'stripe_subscription_id' => $subscription->id,
            'stripe_event_id' => $event->id,
            'event_type' => 'subscription_deleted',
            'old_status' => $oldStatus,
            'new_status' => 'canceled',
            'actor' => 'stripe',
            'description' => 'Subscription canceled/deleted',
            'event_payload' => (array) $event->data->object,
            'occurred_at' => \Carbon\Carbon::createFromTimestamp($event->created),
            'processed_at' => now(),
        ]);

        BillingActivityLog::log(
            'subscription_canceled',
            'success',
            $sub->user_uuid,
            $sub->id,
            null,
            'Subscription was canceled',
            [
                'actor_type' => 'stripe',
                'old_value' => ['status' => $oldStatus],
                'new_value' => ['status' => 'canceled'],
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $subscription->id,
            ]
        );

        return [
            'actions' => ['subscription_canceled'],
            'affected' => [['type' => 'subscription', 'id' => $sub->id]],
        ];
    }

    protected function handleInvoiceCreated(Event $event): array
    {
        $invoice = $event->data->object;

        $sub = Subscription::where('stripe_subscription_id', $invoice->subscription)->first();

        if (!$sub) {
            return ['actions' => ['subscription_not_found_for_invoice'], 'affected' => []];
        }

        $tx = Transaction::create([
            'user_uuid' => $sub->user_uuid,
            'subscription_id' => $sub->id,
            'plan_id' => $sub->plan_id,
            'stripe_invoice_id' => $invoice->id,
            'stripe_subscription_id' => $invoice->subscription,
            'stripe_customer_id' => $invoice->customer,
            'invoice_number' => $invoice->number,
            'invoice_pdf_url' => $invoice->invoice_pdf,
            'invoice_hosted_url' => $invoice->hosted_invoice_url,
            'billing_reason' => $invoice->billing_reason,
            'amount_subtotal' => $invoice->subtotal,
            'amount_tax' => $invoice->tax ?? 0,
            'amount_total' => $invoice->total,
            'amount' => $invoice->total,
            'amount_due' => $invoice->amount_due,
            'currency' => strtoupper($invoice->currency),
            'status' => 'open',
            'due_date' => $invoice->due_date ? \Carbon\Carbon::createFromTimestamp($invoice->due_date) : null,
            'period_start' => $invoice->period_start ? \Carbon\Carbon::createFromTimestamp($invoice->period_start) : null,
            'period_end' => $invoice->period_end ? \Carbon\Carbon::createFromTimestamp($invoice->period_end) : null,
        ]);

        BillingActivityLog::log(
            'invoice_created',
            'success',
            $sub->user_uuid,
            $sub->id,
            $tx->id,
            "Invoice {$invoice->number} created for " . number_format($invoice->total / 100, 2) . " " . strtoupper($invoice->currency),
            [
                'actor_type' => 'stripe',
                'amount' => $invoice->total,
                'currency' => strtoupper($invoice->currency),
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $invoice->id,
            ]
        );

        return [
            'actions' => ['invoice_created'],
            'affected' => [['type' => 'transaction', 'id' => $tx->id]],
        ];
    }

    protected function handleInvoicePaymentSucceeded(Event $event): array
    {
        $invoice = $event->data->object;

        $sub = Subscription::where('stripe_subscription_id', $invoice->subscription)->first();

        if (!$sub) {
            return ['actions' => ['subscription_not_found_for_payment'], 'affected' => []];
        }

        $existingTx = Transaction::where('stripe_invoice_id', $invoice->id)->first();
        $receiptUrl = null;

        if ($invoice->charge && $this->stripe) {
            try {
                $charge = $this->stripe->charges->retrieve($invoice->charge);
                $receiptUrl = $charge->receipt_url ?? null;
            } catch (\Exception $e) {
                Log::warning("Could not retrieve charge receipt: " . $e->getMessage());
            }
        }

        $affectedRecords = [];

        if ($existingTx) {
            $existingTx->update([
                'status' => 'paid',
                'payment_status' => 'succeeded',
                'stripe_payment_intent_id' => $invoice->payment_intent,
                'stripe_charge_id' => $invoice->charge,
                'amount_paid' => $invoice->amount_paid,
                'amount_remaining' => $invoice->amount_remaining,
                'paid_at' => now(),
                'invoice_pdf_url' => $invoice->invoice_pdf,
                'invoice_hosted_url' => $invoice->hosted_invoice_url,
                'receipt_url' => $receiptUrl,
            ]);
            $affectedRecords[] = ['type' => 'transaction', 'id' => $existingTx->id, 'action' => 'updated'];
            $txId = $existingTx->id;
        } else {
            $newTx = Transaction::create([
                'user_uuid' => $sub->user_uuid,
                'subscription_id' => $sub->id,
                'plan_id' => $sub->plan_id,
                'stripe_invoice_id' => $invoice->id,
                'stripe_payment_intent_id' => $invoice->payment_intent,
                'stripe_charge_id' => $invoice->charge,
                'stripe_subscription_id' => $invoice->subscription,
                'stripe_customer_id' => $invoice->customer,
                'invoice_number' => $invoice->number,
                'invoice_pdf_url' => $invoice->invoice_pdf,
                'invoice_hosted_url' => $invoice->hosted_invoice_url,
                'receipt_url' => $receiptUrl,
                'billing_reason' => $invoice->billing_reason,
                'amount_subtotal' => $invoice->subtotal,
                'amount_tax' => $invoice->tax ?? 0,
                'amount_total' => $invoice->total,
                'amount' => $invoice->amount_paid,
                'amount_paid' => $invoice->amount_paid,
                'amount_due' => $invoice->amount_due,
                'amount_remaining' => $invoice->amount_remaining,
                'currency' => strtoupper($invoice->currency),
                'status' => 'paid',
                'payment_status' => 'succeeded',
                'paid_at' => now(),
                'period_start' => $invoice->period_start ? \Carbon\Carbon::createFromTimestamp($invoice->period_start) : null,
                'period_end' => $invoice->period_end ? \Carbon\Carbon::createFromTimestamp($invoice->period_end) : null,
            ]);
            $affectedRecords[] = ['type' => 'transaction', 'id' => $newTx->id, 'action' => 'created'];
            $txId = $newTx->id;
        }

        $sub->update([
            'past_due_since' => null,
            'dunning_status' => 'none',
            'payment_retry_count' => 0,
            'last_payment_error' => null,
            'synced_at' => now(),
        ]);

        SubscriptionEvent::create([
            'subscription_id' => $sub->id,
            'user_uuid' => $sub->user_uuid,
            'stripe_subscription_id' => $invoice->subscription,
            'stripe_event_id' => $event->id,
            'event_type' => 'payment_succeeded',
            'amount' => $invoice->amount_paid,
            'currency' => strtoupper($invoice->currency),
            'actor' => 'stripe',
            'description' => "Payment of " . number_format($invoice->amount_paid / 100, 2) . " " . strtoupper($invoice->currency) . " succeeded",
            'occurred_at' => \Carbon\Carbon::createFromTimestamp($event->created),
            'processed_at' => now(),
        ]);

        BillingActivityLog::log(
            'payment_succeeded',
            'success',
            $sub->user_uuid,
            $sub->id,
            $txId,
            "Payment of " . number_format($invoice->amount_paid / 100, 2) . " " . strtoupper($invoice->currency) . " succeeded for invoice {$invoice->number}",
            [
                'actor_type' => 'stripe',
                'amount' => $invoice->amount_paid,
                'currency' => strtoupper($invoice->currency),
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $invoice->id,
            ]
        );

        return [
            'actions' => ['payment_succeeded'],
            'affected' => $affectedRecords,
        ];
    }

    protected function handleInvoicePaymentFailed(Event $event): array
    {
        $invoice = $event->data->object;

        $sub = Subscription::where('stripe_subscription_id', $invoice->subscription)->first();

        if (!$sub) {
            return ['actions' => ['subscription_not_found_for_failed_payment'], 'affected' => []];
        }

        $failureCode = 'unknown';
        $failureMessage = 'Payment failed';

        if ($invoice->payment_intent && $this->stripe) {
            try {
                $paymentIntent = $this->stripe->paymentIntents->retrieve($invoice->payment_intent);
                $failureCode = $paymentIntent->last_payment_error->code ?? 'unknown';
                $failureMessage = $paymentIntent->last_payment_error->message ?? 'Payment failed';
            } catch (\Exception $e) {
                Log::warning("Could not retrieve payment intent: " . $e->getMessage());
            }
        }

        $existingTx = Transaction::where('stripe_invoice_id', $invoice->id)->first();
        $affectedRecords = [];

        if ($existingTx) {
            $existingTx->update([
                'status' => 'failed',
                'payment_status' => 'failed',
                'failure_code' => $failureCode,
                'failure_message' => $failureMessage,
                'attempt_count' => $invoice->attempt_count,
                'next_payment_attempt' => $invoice->next_payment_attempt ? \Carbon\Carbon::createFromTimestamp($invoice->next_payment_attempt) : null,
            ]);
            $txId = $existingTx->id;
            $affectedRecords[] = ['type' => 'transaction', 'id' => $existingTx->id];
        } else {
            $newTx = Transaction::create([
                'user_uuid' => $sub->user_uuid,
                'subscription_id' => $sub->id,
                'plan_id' => $sub->plan_id,
                'stripe_invoice_id' => $invoice->id,
                'stripe_payment_intent_id' => $invoice->payment_intent,
                'stripe_subscription_id' => $invoice->subscription,
                'stripe_customer_id' => $invoice->customer,
                'invoice_number' => $invoice->number,
                'billing_reason' => $invoice->billing_reason,
                'amount_subtotal' => $invoice->subtotal,
                'amount_tax' => $invoice->tax ?? 0,
                'amount_total' => $invoice->total,
                'amount' => $invoice->total,
                'amount_due' => $invoice->amount_due,
                'currency' => strtoupper($invoice->currency),
                'status' => 'failed',
                'payment_status' => 'failed',
                'failure_code' => $failureCode,
                'failure_message' => $failureMessage,
                'attempt_count' => $invoice->attempt_count,
                'next_payment_attempt' => $invoice->next_payment_attempt ? \Carbon\Carbon::createFromTimestamp($invoice->next_payment_attempt) : null,
                'period_start' => $invoice->period_start ? \Carbon\Carbon::createFromTimestamp($invoice->period_start) : null,
                'period_end' => $invoice->period_end ? \Carbon\Carbon::createFromTimestamp($invoice->period_end) : null,
            ]);
            $txId = $newTx->id;
            $affectedRecords[] = ['type' => 'transaction', 'id' => $newTx->id];
        }

        $sub->update([
            'last_payment_attempt_at' => now(),
            'last_payment_error' => $failureMessage,
            'payment_retry_count' => ($sub->payment_retry_count ?? 0) + 1,
            'next_payment_retry_at' => $invoice->next_payment_attempt ? \Carbon\Carbon::createFromTimestamp($invoice->next_payment_attempt) : null,
            'synced_at' => now(),
        ]);

        SubscriptionEvent::create([
            'subscription_id' => $sub->id,
            'user_uuid' => $sub->user_uuid,
            'stripe_subscription_id' => $invoice->subscription,
            'stripe_event_id' => $event->id,
            'event_type' => 'payment_failed',
            'amount' => $invoice->amount_due,
            'currency' => strtoupper($invoice->currency),
            'failure_code' => $failureCode,
            'failure_message' => $failureMessage,
            'actor' => 'stripe',
            'description' => "Payment failed: {$failureMessage}",
            'occurred_at' => \Carbon\Carbon::createFromTimestamp($event->created),
            'processed_at' => now(),
        ]);

        BillingActivityLog::log(
            'payment_failed',
            'failed',
            $sub->user_uuid,
            $sub->id,
            $txId,
            "Payment failed for invoice {$invoice->number}: {$failureMessage}",
            [
                'actor_type' => 'stripe',
                'amount' => $invoice->amount_due,
                'currency' => strtoupper($invoice->currency),
                'error_code' => $failureCode,
                'error_message' => $failureMessage,
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $invoice->id,
            ]
        );

        $customer = Customer::where('uuid', $sub->user_uuid)->first();
        if ($customer) {
            BillingNotification::create([
                'user_uuid' => $sub->user_uuid,
                'subscription_id' => $sub->id,
                'type' => 'payment_failed',
                'notification_type' => 'payment_failed',
                'channel' => 'email',
                'priority' => 'urgent',
                'status' => 'sent',
                'title' => 'Payment Failed',
                'message' => "Payment of " . number_format($invoice->amount_due / 100, 2) . " " . strtoupper($invoice->currency) . " failed",
                'recipient_email' => $customer->email,
                'subject' => 'Payment Failed - Action Required',
                'template_name' => 'payment_failed',
                'template_data' => [
                    'firstName' => $customer->firstname,
                    'amount' => $invoice->amount_due / 100,
                    'currency' => strtoupper($invoice->currency),
                    'failureReason' => $failureMessage,
                    'nextRetry' => $invoice->next_payment_attempt ? \Carbon\Carbon::createFromTimestamp($invoice->next_payment_attempt)->toIso8601String() : null,
                ],
                'scheduled_at' => now(),
            ]);
        }

        return [
            'actions' => ['payment_failed_recorded'],
            'affected' => $affectedRecords,
        ];
    }

    protected function handleChargeRefunded(Event $event): array
    {
        $charge = $event->data->object;

        $tx = Transaction::where('stripe_charge_id', $charge->id)->first();

        if (!$tx) {
            return ['actions' => ['transaction_not_found_for_refund'], 'affected' => []];
        }

        $refundAmount = $charge->amount_refunded;
        $isFullRefund = $charge->refunded && $charge->amount_refunded === $charge->amount;

        $tx->update([
            'status' => $isFullRefund ? 'refunded' : 'partially_refunded',
            'refund_amount' => $refundAmount,
            'refunded_at' => now(),
            'stripe_refund_id' => $charge->refunds->data[0]->id ?? null,
        ]);

        BillingActivityLog::log(
            'payment_refunded',
            'success',
            $tx->user_uuid,
            $tx->subscription_id,
            $tx->id,
            ($isFullRefund ? 'Full' : 'Partial') . " refund of " . number_format($refundAmount / 100, 2) . " " . strtoupper($charge->currency),
            [
                'actor_type' => 'stripe',
                'amount' => $refundAmount,
                'currency' => strtoupper($charge->currency),
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $charge->id,
            ]
        );

        return [
            'actions' => ['refund_processed'],
            'affected' => [['type' => 'transaction', 'id' => $tx->id]],
        ];
    }

    protected function handlePaymentMethodAttached(Event $event): array
    {
        $paymentMethod = $event->data->object;
        $customerId = $paymentMethod->customer;

        $customer = Customer::where('stripe_customer_id', $customerId)->first();

        if (!$customer) {
            return ['actions' => ['customer_not_found_for_payment_method'], 'affected' => []];
        }

        $cardBrand = $paymentMethod->card->brand ?? null;
        $cardLast4 = $paymentMethod->card->last4 ?? null;
        
        $billingDetailsArray = [];
        if ($paymentMethod->billing_details) {
            $bd = $paymentMethod->billing_details;
            $billingDetailsArray = [
                'name' => $bd->name ?? null,
                'email' => $bd->email ?? null,
                'phone' => $bd->phone ?? null,
                'address' => $bd->address ? [
                    'city' => $bd->address->city ?? null,
                    'country' => $bd->address->country ?? null,
                    'line1' => $bd->address->line1 ?? null,
                    'line2' => $bd->address->line2 ?? null,
                    'postal_code' => $bd->address->postal_code ?? null,
                    'state' => $bd->address->state ?? null,
                ] : null,
            ];
        }

        $pm = PaymentMethod::updateOrCreate(
            ['stripe_payment_method_id' => $paymentMethod->id],
            [
                'user_uuid' => $customer->uuid,
                'stripe_customer_id' => $customerId,
                'type' => $paymentMethod->type,
                'brand' => $cardBrand,
                'card_brand' => $cardBrand ? strtoupper($cardBrand) : null,
                'last4' => $cardLast4,
                'card_last4' => $cardLast4,
                'exp_month' => $paymentMethod->card->exp_month ?? null,
                'exp_year' => $paymentMethod->card->exp_year ?? null,
                'funding' => $paymentMethod->card->funding ?? null,
                'country' => $paymentMethod->card->country ?? null,
                'billing_details' => $billingDetailsArray,
                'fingerprint' => $paymentMethod->card->fingerprint ?? null,
                'wallet' => $paymentMethod->card->wallet->type ?? null,
                'status' => 'active',
            ]
        );

        $wasRecentlyCreated = $pm->wasRecentlyCreated;
        $action = $wasRecentlyCreated ? 'payment_method_added' : 'payment_method_updated';

        BillingActivityLog::log(
            $wasRecentlyCreated ? 'card_added' : 'card_updated',
            'success',
            $customer->uuid,
            null,
            null,
            ($wasRecentlyCreated ? "Payment method added: " : "Payment method updated: ") . ($cardBrand ?? 'Card') . " ending in " . ($cardLast4 ?? '****'),
            [
                'actor_type' => 'stripe',
                'new_value' => [
                    'brand' => $cardBrand,
                    'last4' => $cardLast4,
                ],
                'stripe_event_id' => $event->id,
                'stripe_object_id' => $paymentMethod->id,
            ]
        );

        return [
            'actions' => [$action],
            'affected' => [['type' => 'payment_method', 'id' => $pm->id]],
        ];
    }

    protected function handlePaymentMethodDetached(Event $event): array
    {
        $paymentMethod = $event->data->object;

        $updated = PaymentMethod::where('stripe_payment_method_id', $paymentMethod->id)
            ->update(['status' => 'deleted']);

        if ($updated === 0) {
            return ['actions' => ['payment_method_not_found'], 'affected' => []];
        }

        return [
            'actions' => ['payment_method_detached'],
            'affected' => [['type' => 'payment_method', 'stripe_id' => $paymentMethod->id]],
        ];
    }
}
