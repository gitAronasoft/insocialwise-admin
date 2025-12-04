@extends('admin.layouts.app')

@section('title', 'Edit Subscription Plan')

@section('content')
<style>
.tooltip-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
}
.tooltip-icon {
    cursor: help;
    color: #9ca3af;
}
.tooltip-icon:hover {
    color: #6b7280;
}
.tooltip-text {
    visibility: hidden;
    opacity: 0;
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #1f2937;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 50;
    margin-bottom: 8px;
    max-width: 280px;
    white-space: normal;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: opacity 0.15s ease-in-out, visibility 0.15s ease-in-out;
}
.tooltip-text::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-width: 6px;
    border-style: solid;
    border-color: #1f2937 transparent transparent transparent;
}
.tooltip-wrapper:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}
</style>

<div class="space-y-6" x-data="planForm()">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Subscription Plan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update pricing plan settings</p>
        </div>
        <a href="{{ route('admin.subscription-plans.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Plans
        </a>
    </div>

    @if($stripeConfigured ?? false)
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm text-green-800 dark:text-green-200">Stripe is connected. Changes will sync automatically when saved.</span>
            </div>
            @if($plan->stripe_product_id)
            <span class="text-xs text-green-600 dark:text-green-400 font-mono">{{ $plan->stripe_product_id }}</span>
            @endif
        </div>
    </div>
    @else
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm text-amber-800 dark:text-amber-200">Stripe not configured. Changes will be saved locally only.</span>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <form action="{{ route('admin.subscription-plans.update', $plan) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">Basic Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Plan Name
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">The name customers will see (e.g., Basic, Pro, Enterprise)</span>
                            </span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $plan->name) }}" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="e.g., Basic, Pro, Enterprise">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Currency
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">The currency for all prices in this plan</span>
                            </span>
                        </label>
                        <select name="currency" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="USD" {{ old('currency', $plan->currency) === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                            <option value="EUR" {{ old('currency', $plan->currency) === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            <option value="GBP" {{ old('currency', $plan->currency) === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                            <option value="INR" {{ old('currency', $plan->currency) === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                            <option value="CAD" {{ old('currency', $plan->currency) === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                            <option value="AUD" {{ old('currency', $plan->currency) === 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Description
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span class="tooltip-text">Brief description shown below the plan name</span>
                        </span>
                    </label>
                    <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Brief description of this plan...">{{ old('description', $plan->description) }}</textarea>
                </div>
            </div>

            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">Pricing</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Monthly Price
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">The monthly subscription price</span>
                            </span>
                        </label>
                        <input type="number" name="price" x-model="monthlyPrice" step="0.01" min="0"
                            x-bind:required="!isContactOnly" x-bind:disabled="isContactOnly"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'bg-gray-100 dark:bg-gray-800 opacity-50': isContactOnly }"
                            placeholder="0.00">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Yearly Discount %
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">Discount when customer pays yearly (e.g., 20% = save 20%)</span>
                            </span>
                        </label>
                        <input type="number" name="yearly_discount_percent" x-model="yearlyDiscount" min="0" max="100"
                            x-bind:disabled="isContactOnly"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'bg-gray-100 dark:bg-gray-800 opacity-50': isContactOnly }"
                            placeholder="e.g., 20">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Yearly Price
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">Auto-calculated: Monthly x 12 minus discount</span>
                            </span>
                        </label>
                        <div class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-3 py-2.5 text-gray-900 dark:text-white">
                            <span x-text="calculatedYearlyPrice"></span>
                            <span x-show="yearlySavings > 0" class="text-green-600 dark:text-green-400 text-sm ml-2">(Save $<span x-text="yearlySavings"></span>)</span>
                        </div>
                        <input type="hidden" name="yearly_price" :value="yearlyPriceValue">
                    </div>
                </div>
            </div>

            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">Trial Period</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Trial Days
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">Number of free trial days before billing starts</span>
                            </span>
                        </label>
                        <input type="number" name="trial_period_days" value="{{ old('trial_period_days', $plan->trial_period_days) }}" min="0"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="e.g., 14 or 30">
                    </div>

                    <div class="flex items-end pb-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="trial_enabled" value="1" {{ old('trial_enabled', $plan->trial_enabled ?? false) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                            <span class="text-sm text-gray-900 dark:text-white">Enable Trial</span>
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">When enabled, customers can try this plan for free</span>
                            </span>
                        </label>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Skip Trial Discount
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">Discount if customer skips trial and pays immediately</span>
                            </span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="skip_trial_discount_enabled" value="1" {{ old('skip_trial_discount_enabled', $plan->skip_trial_discount_enabled ?? false) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                            <input type="number" name="skip_trial_discount_percent" value="{{ old('skip_trial_discount_percent', $plan->skip_trial_discount_percent ?? 10) }}" min="0" max="100"
                                class="w-20 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="text-sm text-gray-500">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">Plan Limits</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Max Social Accounts
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">Total social accounts user can connect. -1 = unlimited</span>
                            </span>
                        </label>
                        <input type="number" name="max_social_accounts" value="{{ old('max_social_accounts', $plan->max_social_accounts) }}" min="-1"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="-1 for unlimited">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Max Team Members
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">Number of team members allowed. -1 = unlimited</span>
                            </span>
                        </label>
                        <input type="number" name="max_team_members" value="{{ old('max_team_members', $plan->max_team_members) }}" min="-1"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="-1 for unlimited">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Max Scheduled Posts
                            <span class="tooltip-wrapper">
                                <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="tooltip-text">Maximum posts in queue. -1 = unlimited</span>
                            </span>
                        </label>
                        <input type="number" name="max_scheduled_posts" value="{{ old('max_scheduled_posts', $plan->max_scheduled_posts) }}" min="-1"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="-1 for unlimited">
                    </div>
                </div>
            </div>

            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-5">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Platform Access</h4>
                    <span class="tooltip-wrapper">
                        <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="tooltip-text">Choose which platforms are allowed and page limits</span>
                    </span>
                </div>
                @php $platformLimits = $plan->platform_limits ?? []; @endphp
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($platforms ?? [] as $key => $name)
                    <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <label class="flex items-center gap-2 mb-3">
                            <input type="checkbox" name="platform_limits[{{ $key }}][enabled]" value="1"
                                {{ isset($platformLimits[$key]['enabled']) && $platformLimits[$key]['enabled'] ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $name }}</span>
                        </label>
                        <div>
                            <label class="text-xs text-gray-500 dark:text-gray-400">Max Pages</label>
                            <input type="number" name="platform_limits[{{ $key }}][max_pages]" 
                                value="{{ $platformLimits[$key]['max_pages'] ?? -1 }}" min="-1"
                                class="w-full mt-1 text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="-1 = unlimited">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-5">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Features</h4>
                    <button type="button" @click="addFeature()" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">+ Add Feature</button>
                </div>
                <div class="space-y-3">
                    <template x-for="(feature, index) in features" :key="index">
                        <div class="flex items-center gap-3">
                            <input type="text" :name="`features[${index}]`" x-model="features[index]"
                                class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., Unlimited storage, Priority support">
                            <button type="button" @click="removeFeature(index)" class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                    <div x-show="features.length === 0" class="text-sm text-gray-500 dark:text-gray-400 italic py-4 text-center bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        No features added yet. Click "Add Feature" to list what this plan offers.
                    </div>
                </div>
            </div>

            <div class="pb-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">Plan Options</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                        <input type="checkbox" name="active" value="1" {{ old('active', $plan->active) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white block">Active</span>
                            <span class="text-xs text-gray-500">Available for purchase</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }}
                            class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 dark:border-gray-600 rounded">
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white block">Featured</span>
                            <span class="text-xs text-gray-500">"Most Popular" badge</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                        <input type="checkbox" name="show_on_landing" value="1" {{ old('show_on_landing', $plan->show_on_landing) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white block">Show on Landing</span>
                            <span class="text-xs text-gray-500">Display on pricing page</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                        <input type="checkbox" name="is_contact_only" value="1" x-model="isContactOnly"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 rounded">
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white block">Contact Only</span>
                            <span class="text-xs text-gray-500">"Contact Sales" button</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Last updated: {{ $plan->updated_at->format('M d, Y H:i') }}
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.subscription-plans.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2.5 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Cancel</a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 font-medium transition-colors">Update Plan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function planForm() {
    return {
        features: @json($plan->features ?? []),
        isContactOnly: {{ $plan->is_contact_only ? 'true' : 'false' }},
        monthlyPrice: {{ old('price', $plan->price ?? 0) }},
        yearlyDiscount: {{ old('yearly_discount_percent', $plan->yearly_discount_percent ?? 0) }},
        
        get yearlyPriceValue() {
            if (!this.monthlyPrice || this.isContactOnly) return 0;
            return (this.monthlyPrice * 12 * (1 - this.yearlyDiscount / 100)).toFixed(2);
        },
        
        get calculatedYearlyPrice() {
            if (!this.monthlyPrice || this.isContactOnly) return '$0.00';
            const yearly = this.monthlyPrice * 12 * (1 - this.yearlyDiscount / 100);
            return '$' + yearly.toFixed(2);
        },
        
        get yearlySavings() {
            if (!this.monthlyPrice || !this.yearlyDiscount || this.isContactOnly) return 0;
            return (this.monthlyPrice * 12 * this.yearlyDiscount / 100).toFixed(2);
        },
        
        addFeature() { this.features.push(''); },
        removeFeature(index) { this.features.splice(index, 1); }
    }
}
</script>
@endsection
