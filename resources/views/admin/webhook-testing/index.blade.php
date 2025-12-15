@extends('admin.layouts.app')

@section('title', 'Webhook Testing Interface')

@section('content')
<div x-data="webhookTesting()" class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Webhook Logs', 'url' => route('admin.webhook-logs.index')],
        ['label' => 'Testing Interface', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Webhook Testing Interface</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Test and replay webhook events for debugging</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Send Test Webhook</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Simulate webhook events for testing</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Event Type</label>
                    <select x-model="testPayload.event_type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select event type...</option>
                        <optgroup label="Customer Events">
                            <option value="customer.created">customer.created</option>
                            <option value="customer.updated">customer.updated</option>
                            <option value="customer.deleted">customer.deleted</option>
                        </optgroup>
                        <optgroup label="Subscription Events">
                            <option value="customer.subscription.created">customer.subscription.created</option>
                            <option value="customer.subscription.updated">customer.subscription.updated</option>
                            <option value="customer.subscription.deleted">customer.subscription.deleted</option>
                            <option value="customer.subscription.trial_will_end">customer.subscription.trial_will_end</option>
                        </optgroup>
                        <optgroup label="Invoice Events">
                            <option value="invoice.created">invoice.created</option>
                            <option value="invoice.paid">invoice.paid</option>
                            <option value="invoice.payment_failed">invoice.payment_failed</option>
                            <option value="invoice.upcoming">invoice.upcoming</option>
                        </optgroup>
                        <optgroup label="Payment Events">
                            <option value="payment_intent.succeeded">payment_intent.succeeded</option>
                            <option value="payment_intent.payment_failed">payment_intent.payment_failed</option>
                            <option value="charge.refunded">charge.refunded</option>
                        </optgroup>
                        <optgroup label="Payment Method Events">
                            <option value="payment_method.attached">payment_method.attached</option>
                            <option value="payment_method.detached">payment_method.detached</option>
                        </optgroup>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer ID (optional)</label>
                    <input type="text" x-model="testPayload.customer_id" placeholder="cus_xxxxxxxx" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subscription ID (optional)</label>
                    <input type="text" x-model="testPayload.subscription_id" placeholder="sub_xxxxxxxx" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Custom Payload (JSON)</label>
                    <textarea x-model="testPayload.custom_data" rows="6" placeholder='{"key": "value"}' class="w-full font-mono text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

                <div class="flex items-center gap-4">
                    <button @click="sendTestWebhook()" :disabled="sending || !testPayload.event_type" class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg x-show="!sending" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg x-show="sending" class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="sending ? 'Sending...' : 'Send Test Event'"></span>
                    </button>
                    <button @click="resetForm()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Test Results</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">View response from test webhook</p>
            </div>
            <div class="p-6">
                <template x-if="!testResult">
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Send a test webhook to see results</p>
                    </div>
                </template>
                <template x-if="testResult">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div :class="testResult.success ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30'" class="w-10 h-10 rounded-lg flex items-center justify-center">
                                <svg x-show="testResult.success" class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <svg x-show="!testResult.success" class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white" x-text="testResult.success ? 'Webhook Processed Successfully' : 'Webhook Processing Failed'"></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400" x-text="'Processing time: ' + testResult.processing_time + 'ms'"></p>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Response</h4>
                            <pre class="text-xs font-mono text-gray-600 dark:text-gray-400 whitespace-pre-wrap overflow-x-auto" x-text="JSON.stringify(testResult.response, null, 2)"></pre>
                        </div>

                        <div x-show="testResult.event_id" class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Event Details</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Event ID:</span>
                                    <span class="font-mono text-gray-900 dark:text-white" x-text="testResult.event_id"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                    <span :class="testResult.status === 'processed' ? 'text-green-600' : 'text-red-600'" x-text="testResult.status"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Failed Events (Replay Queue)</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Click to replay failed webhook events</p>
                </div>
                <button @click="loadFailedEvents()" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Error</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-for="event in failedEvents" :key="event.id">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm text-gray-900 dark:text-white" x-text="event.stripe_event_id"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" x-text="event.event_type"></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-red-600 dark:text-red-400 truncate max-w-xs block" x-text="event.error_message || 'Unknown error'"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="event.created_at"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button @click="replayEvent(event.id)" :disabled="event.replaying" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 disabled:opacity-50">
                                    <svg x-show="!event.replaying" class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <svg x-show="event.replaying" class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-text="event.replaying ? 'Replaying...' : 'Replay'"></span>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="failedEvents.length === 0">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            No failed events to replay
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function webhookTesting() {
    return {
        sending: false,
        testPayload: {
            event_type: '',
            customer_id: '',
            subscription_id: '',
            custom_data: ''
        },
        testResult: null,
        failedEvents: [],

        init() {
            this.loadFailedEvents();
        },

        async sendTestWebhook() {
            this.sending = true;
            this.testResult = null;

            try {
                const response = await fetch('/admin/webhook-testing/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.testPayload)
                });

                this.testResult = await response.json();
            } catch (error) {
                this.testResult = {
                    success: false,
                    response: { error: error.message },
                    processing_time: 0
                };
            } finally {
                this.sending = false;
            }
        },

        resetForm() {
            this.testPayload = {
                event_type: '',
                customer_id: '',
                subscription_id: '',
                custom_data: ''
            };
            this.testResult = null;
        },

        async loadFailedEvents() {
            try {
                const response = await fetch('/admin/webhook-testing/failed-events');
                const data = await response.json();
                this.failedEvents = data.events || [];
            } catch (error) {
                console.error('Failed to load events:', error);
            }
        },

        async replayEvent(eventId) {
            const event = this.failedEvents.find(e => e.id === eventId);
            if (event) event.replaying = true;

            try {
                const response = await fetch(`/admin/webhook-logs/${eventId}/retry`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const result = await response.json();
                if (result.success) {
                    this.loadFailedEvents();
                }
            } catch (error) {
                console.error('Failed to replay event:', error);
            } finally {
                if (event) event.replaying = false;
            }
        }
    }
}
</script>
@endsection
