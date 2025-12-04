@extends('admin.layouts.app')

@section('title', 'Create Subscription Plan')

@section('content')
<style>
.tooltip-wrapper { position: relative; display: inline-flex; align-items: center; }
.tooltip-icon { cursor: help; color: #9ca3af; margin-left: 4px; }
.tooltip-icon:hover { color: #6b7280; }
.tooltip-text {
    visibility: hidden; opacity: 0; position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
    background-color: #1f2937; color: white; padding: 8px 12px; border-radius: 6px; font-size: 12px;
    z-index: 50; margin-left: 8px; max-width: 280px; white-space: normal; text-align: left;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: opacity 0.15s ease-in-out;
}
.tooltip-text::after {
    content: ''; position: absolute; right: 100%; top: 50%; transform: translateY(-50%);
    border-width: 6px; border-style: solid; border-color: transparent #1f2937 transparent transparent;
}
.tooltip-wrapper:hover .tooltip-text { visibility: visible; opacity: 1; }
</style>

<div class="space-y-6" x-data="planForm()">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Create Subscription Plan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Set up a new pricing plan with features and pricing</p>
        </div>
        <a href="{{ route('admin.subscription-plans.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Plans
        </a>
    </div>

    @if($stripeConfigured ?? false)
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm text-green-800 dark:text-green-200">Stripe is connected. Plans will sync automatically when saved.</span>
        </div>
    </div>
    @else
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm text-amber-800 dark:text-amber-200">Stripe not configured. Plans will be saved locally only.</span>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.subscription-plans.store') }}" method="POST">
        @csrf

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Basic Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Plan Name *
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">The name customers will see (e.g., Basic, Pro, Enterprise)</span>
                        </span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., Starter, Professional, Enterprise">
                    @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        URL Slug
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">URL-friendly identifier. Auto-generated from name if left empty.</span>
                        </span>
                    </label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="auto-generated if empty">
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Primary Currency
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Primary currency for Stripe billing. Both USD and INR prices are stored.</span>
                        </span>
                    </label>
                    <select name="currency" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                        <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                    </select>
                </div>
            </div>
            <div class="mt-5">
                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Description
                    <span class="tooltip-wrapper">
                        <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <span class="tooltip-text">Short description shown on pricing page below plan name</span>
                    </span>
                </label>
                <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Brief description shown to customers...">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Pricing (Dual Currency)
                <span class="tooltip-wrapper">
                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <span class="tooltip-text">Set prices in both USD and INR. Yearly prices auto-calculate based on discount %.</span>
                </span>
            </h4>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl font-bold text-blue-600">$</span>
                        <span class="font-semibold text-gray-900 dark:text-white">USD Pricing</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Monthly
                                <span class="tooltip-wrapper">
                                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                    <span class="tooltip-text">Monthly subscription price in USD</span>
                                </span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" name="monthly_price_usd" x-model="monthlyUsd" step="0.01" min="0" x-bind:disabled="isContactOnly"
                                    class="w-full pl-7 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'opacity-50': isContactOnly }" placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Yearly
                                <span class="tooltip-wrapper">
                                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                    <span class="tooltip-text">Auto-calculated: Monthly x 12 minus discount</span>
                                </span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                <input type="text" :value="yearlyUsdDisplay" disabled
                                    class="w-full pl-7 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <input type="hidden" name="yearly_price_usd" :value="yearlyUsd">
                            </div>
                        </div>
                    </div>
                    <div x-show="savingsUsd > 0" class="mt-3 text-sm text-green-600 dark:text-green-400 font-medium">
                        Save $<span x-text="savingsUsd"></span>/year
                    </div>
                </div>

                <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-5 border border-orange-200 dark:border-orange-800">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl font-bold text-orange-600">&#8377;</span>
                        <span class="font-semibold text-gray-900 dark:text-white">INR Pricing</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Monthly
                                <span class="tooltip-wrapper">
                                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                    <span class="tooltip-text">Monthly subscription price in INR</span>
                                </span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">&#8377;</span>
                                <input type="number" name="monthly_price_inr" x-model="monthlyInr" step="0.01" min="0" x-bind:disabled="isContactOnly"
                                    class="w-full pl-7 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'opacity-50': isContactOnly }" placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Yearly
                                <span class="tooltip-wrapper">
                                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                    <span class="tooltip-text">Auto-calculated: Monthly x 12 minus discount</span>
                                </span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">&#8377;</span>
                                <input type="text" :value="yearlyInrDisplay" disabled
                                    class="w-full pl-7 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <input type="hidden" name="yearly_price_inr" :value="yearlyInr">
                            </div>
                        </div>
                    </div>
                    <div x-show="savingsInr > 0" class="mt-3 text-sm text-green-600 dark:text-green-400 font-medium">
                        Save &#8377;<span x-text="savingsInr"></span>/year
                    </div>
                </div>
            </div>

            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Yearly Discount %
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Discount when customer pays yearly (e.g., 20 = save 20%)</span>
                        </span>
                    </label>
                    <input type="number" name="yearly_discount_percent" x-model="yearlyDiscount" min="0" max="100"
                        class="w-full md:w-40 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., 20">
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Legacy Price
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Backward compatibility field for existing integrations</span>
                        </span>
                    </label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" step="0.01" min="0"
                        class="w-full md:w-40 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Plan Limits
                <span class="tooltip-wrapper">
                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <span class="tooltip-text">Set usage limits for this plan. Use -1 for unlimited.</span>
                </span>
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Social Profiles
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Max social media profiles user can connect</span>
                        </span>
                    </label>
                    <input type="number" name="max_social_accounts" value="{{ old('max_social_accounts') }}" min="-1"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="-1 = unlimited">
                    <span class="text-xs text-gray-500 mt-1">-1 for unlimited</span>
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Team Members
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Max team members that can be added</span>
                        </span>
                    </label>
                    <input type="number" name="max_team_members" value="{{ old('max_team_members') }}" min="-1"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="-1 = unlimited">
                    <span class="text-xs text-gray-500 mt-1">-1 for unlimited</span>
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Scheduled Posts
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Max posts in queue at once</span>
                        </span>
                    </label>
                    <input type="number" name="max_scheduled_posts" value="{{ old('max_scheduled_posts') }}" min="-1"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="-1 = unlimited">
                    <span class="text-xs text-gray-500 mt-1">-1 for unlimited</span>
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        AI Tokens/Month
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Monthly AI token quota for automation features</span>
                        </span>
                    </label>
                    <input type="number" name="ai_tokens_per_month" value="{{ old('ai_tokens_per_month', 0) }}" min="-1"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="-1 = unlimited">
                    <span class="text-xs text-gray-500 mt-1">-1 for unlimited</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                AI Automation Features
                <span class="tooltip-wrapper">
                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <span class="tooltip-text">Toggle which AI-powered automation features are included in this plan</span>
                </span>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Auto Comment Reply</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">AI responds to comments automatically</p>
                    </div>
                    <input type="checkbox" name="ai_auto_comment_reply" value="1" {{ old('ai_auto_comment_reply') ? 'checked' : '' }}
                        class="h-5 w-5 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Auto DM Reply</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">AI handles direct messages</p>
                    </div>
                    <input type="checkbox" name="ai_auto_dm_reply" value="1" {{ old('ai_auto_dm_reply') ? 'checked' : '' }}
                        class="h-5 w-5 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Semantic Analysis</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Deep content understanding</p>
                    </div>
                    <input type="checkbox" name="ai_semantic_analysis" value="1" {{ old('ai_semantic_analysis') ? 'checked' : '' }}
                        class="h-5 w-5 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">AI-Driven Reporting</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Smart insights & summaries</p>
                    </div>
                    <input type="checkbox" name="ai_driven_reporting" value="1" {{ old('ai_driven_reporting') ? 'checked' : '' }}
                        class="h-5 w-5 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">AI Content Generator</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Generate posts & captions</p>
                    </div>
                    <input type="checkbox" name="ai_content_generator" value="1" {{ old('ai_content_generator') ? 'checked' : '' }}
                        class="h-5 w-5 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Social Profile Score</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Profile scoring analytics</p>
                    </div>
                    <input type="checkbox" name="social_profile_score" value="1" {{ old('social_profile_score') ? 'checked' : '' }}
                        class="h-5 w-5 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                </label>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Core Platform Features
                <span class="tooltip-wrapper">
                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <span class="tooltip-text">Core platform features included in this plan</span>
                </span>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Calendar & Scheduling</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Post scheduling features</p>
                    </div>
                    <input type="checkbox" name="calendar_scheduling" value="1" {{ old('calendar_scheduling') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Export Reports</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">PDF/CSV report exports</p>
                    </div>
                    <input type="checkbox" name="export_reports" value="1" {{ old('export_reports') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                    <label class="flex items-center font-medium text-gray-900 dark:text-white mb-2">
                        Support Level
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Level of customer support included</span>
                        </span>
                    </label>
                    <select name="support_level" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                        @foreach($supportLevels ?? ['standard' => 'Standard Email', 'priority' => 'Priority', 'priority_chat' => 'Priority Chat', 'enterprise' => '24x7 Enterprise'] as $key => $label)
                        <option value="{{ $key }}" {{ old('support_level', 'standard') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Unified Inbox</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">All messages in one place</p>
                    </div>
                    <input type="checkbox" name="unified_inbox" value="1" {{ old('unified_inbox') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">White Label</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Custom branding</p>
                    </div>
                    <input type="checkbox" name="white_label" value="1" {{ old('white_label') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">FB Ads Analytics</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">View ad performance</p>
                    </div>
                    <input type="checkbox" name="fb_ads_analytics" value="1" {{ old('fb_ads_analytics') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">FB Ads Creation</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Create & manage ads</p>
                    </div>
                    <input type="checkbox" name="fb_ads_creation" value="1" {{ old('fb_ads_creation') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Team Roles & Permissions</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Advanced access control</p>
                    </div>
                    <input type="checkbox" name="team_roles_permissions" value="1" {{ old('team_roles_permissions') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
                <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Client Workspaces</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Separate client spaces</p>
                    </div>
                    <input type="checkbox" name="client_workspaces" value="1" {{ old('client_workspaces') ? 'checked' : '' }}
                        class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                </label>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <div class="flex items-center justify-between mb-5">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    Landing Page Display Features
                    <span class="tooltip-wrapper">
                        <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <span class="tooltip-text">Marketing bullet points shown on pricing page. Customize text for each plan.</span>
                    </span>
                </h4>
                <button type="button" @click="addDisplayFeature()" class="text-sm text-pink-600 dark:text-pink-400 hover:text-pink-800 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Add Item
                </button>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">These marketing feature items are displayed on your pricing page with checkmarks.</p>
            <div class="space-y-3">
                <template x-for="(item, index) in displayFeatures" :key="index">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <input type="text" :name="`display_features[${index}]`" x-model="displayFeatures[index]"
                            class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="e.g., Up to 5 social profiles, Unlimited posts, Priority support">
                        <button type="button" @click="removeDisplayFeature(index)" class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
                <div x-show="displayFeatures.length === 0" class="text-sm text-gray-500 dark:text-gray-400 italic py-6 text-center bg-gray-50 dark:bg-gray-700/30 rounded-lg border-2 border-dashed border-gray-200 dark:border-gray-600">
                    No display features added. Click "Add Item" to add features shown on pricing page.
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Trial Period
                <span class="tooltip-wrapper">
                    <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <span class="tooltip-text">Configure free trial settings for this plan</span>
                </span>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Trial Days
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Number of free trial days before billing starts</span>
                        </span>
                    </label>
                    <input type="number" name="trial_period_days" value="{{ old('trial_period_days') }}" min="0"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., 14">
                </div>
                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="trial_enabled" value="1" {{ old('trial_enabled') ? 'checked' : '' }}
                            class="h-5 w-5 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Enable Trial</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Skip Trial Discount
                        <span class="tooltip-wrapper">
                            <svg class="w-4 h-4 tooltip-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span class="tooltip-text">Discount if customer skips trial and pays immediately</span>
                        </span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="skip_trial_discount_enabled" value="1" {{ old('skip_trial_discount_enabled') ? 'checked' : '' }}
                            class="h-5 w-5 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                        <input type="number" name="skip_trial_discount_percent" value="{{ old('skip_trial_discount_percent', 10) }}" min="0" max="100"
                            class="w-20 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <span class="text-sm text-gray-500">%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Plan Options
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 transition-colors">
                    <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                        class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white block">Active</span>
                        <span class="text-xs text-gray-500">Available for purchase</span>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 transition-colors">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="h-5 w-5 text-amber-500 focus:ring-amber-500 border-gray-300 rounded">
                    <div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white block">Most Popular</span>
                        <span class="text-xs text-gray-500">Highlight badge</span>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 transition-colors">
                    <input type="checkbox" name="show_on_landing" value="1" {{ old('show_on_landing', true) ? 'checked' : '' }}
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white block">Show on Landing</span>
                        <span class="text-xs text-gray-500">Display on pricing page</span>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 transition-colors">
                    <input type="checkbox" name="is_contact_only" value="1" x-model="isContactOnly"
                        class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white block">Contact Only</span>
                        <span class="text-xs text-gray-500">"Contact Sales" button</span>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 font-medium transition-colors shadow-sm">
                Create Plan
            </button>
            <a href="{{ route('admin.subscription-plans.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function planForm() {
    return {
        displayFeatures: [],
        features: [],
        isContactOnly: {{ old('is_contact_only') ? 'true' : 'false' }},
        monthlyUsd: {{ old('monthly_price_usd', 0) }},
        monthlyInr: {{ old('monthly_price_inr', 0) }},
        yearlyDiscount: {{ old('yearly_discount_percent', 0) }},
        
        get yearlyUsd() {
            if (!this.monthlyUsd || this.isContactOnly) return 0;
            return (this.monthlyUsd * 12 * (1 - this.yearlyDiscount / 100)).toFixed(2);
        },
        get yearlyUsdDisplay() {
            return this.yearlyUsd > 0 ? parseFloat(this.yearlyUsd).toFixed(2) : '0.00';
        },
        get yearlyInr() {
            if (!this.monthlyInr || this.isContactOnly) return 0;
            return (this.monthlyInr * 12 * (1 - this.yearlyDiscount / 100)).toFixed(2);
        },
        get yearlyInrDisplay() {
            return this.yearlyInr > 0 ? parseFloat(this.yearlyInr).toFixed(2) : '0.00';
        },
        get savingsUsd() {
            if (!this.monthlyUsd || !this.yearlyDiscount) return 0;
            return (this.monthlyUsd * 12 * this.yearlyDiscount / 100).toFixed(2);
        },
        get savingsInr() {
            if (!this.monthlyInr || !this.yearlyDiscount) return 0;
            return (this.monthlyInr * 12 * this.yearlyDiscount / 100).toFixed(0);
        },
        
        addDisplayFeature() { this.displayFeatures.push(''); },
        removeDisplayFeature(index) { this.displayFeatures.splice(index, 1); },
        addFeature() { this.features.push(''); },
        removeFeature(index) { this.features.splice(index, 1); }
    }
}
</script>
@endsection
