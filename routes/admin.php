<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\KnowledgeBaseController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\MasterControlController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\WebhookController;
use App\Http\Controllers\Admin\ComplianceController;
use App\Http\Controllers\Admin\ApiKeyController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SocialAccountController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\AuditLogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', 'admin.audit'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Subscription Plans routes
    Route::resource('plans', SubscriptionPlanController::class)->names([
        'index' => 'plans.index',
        'create' => 'plans.create',
        'store' => 'plans.store',
        'show' => 'plans.show',
        'edit' => 'plans.edit',
        'update' => 'plans.update',
        'destroy' => 'plans.destroy',
    ]);

    Route::get('/dashboard/revenue-chart', [DashboardController::class, 'getRevenueChart'])->name('dashboard.revenue-chart');
    Route::get('/dashboard/customer-growth', [DashboardController::class, 'getCustomerGrowthChart'])->name('dashboard.customer-growth');
    Route::get('/dashboard/subscription-pie', [DashboardController::class, 'getSubscriptionPieData'])->name('dashboard.subscription-pie');
    Route::get('/dashboard/recent-activity', [DashboardController::class, 'getRecentActivity'])->name('dashboard.recent-activity');
    Route::get('/dashboard/subscription-trends', [DashboardController::class, 'getSubscriptionTrends'])->name('dashboard.subscription-trends');
    Route::get('/dashboard/revenue-by-plan', [DashboardController::class, 'getRevenueByPlan'])->name('dashboard.revenue-by-plan');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/search/quick', [SearchController::class, 'quickSearch'])->name('search.quick');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/unread', [AlertController::class, 'getUnread'])->name('alerts.unread');
    Route::post('/alerts/{alert}/read', [AlertController::class, 'markAsRead'])->name('alerts.mark-read');
    Route::post('/alerts/read-all', [AlertController::class, 'markAllAsRead'])->name('alerts.mark-all-read');
    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy'])->name('alerts.destroy');
    Route::post('/alerts', [AlertController::class, 'create'])->name('alerts.create');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::get('/master-control', [MasterControlController::class, 'index'])->name('master-control.index');
    Route::post('/master-control/toggle', [MasterControlController::class, 'toggle'])->name('master-control.toggle');
    Route::post('/master-control/seed', [MasterControlController::class, 'seed'])->name('master-control.seed');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('customers.bulk-delete');
    Route::post('/customers/bulk-status', [CustomerController::class, 'bulkStatusChange'])->name('customers.bulk-status');
    Route::post('/customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::post('/customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    Route::get('/customers/{customer}/social-accounts', [CustomerController::class, 'socialAccounts'])->name('customers.social-accounts');

    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{page}', [PageController::class, 'show'])->name('pages.show');

    Route::get('/social-accounts', [SocialAccountController::class, 'index'])->name('social-accounts.index');
    Route::get('/social-accounts/{socialAccount}', [SocialAccountController::class, 'show'])->name('social-accounts.show');
    Route::get('/social-accounts/{socialAccount}/health', [SocialAccountController::class, 'getHealthStatus'])->name('social-accounts.health');

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/export', [SubscriptionController::class, 'export'])->name('subscriptions.export');
    Route::get('/subscriptions/transactions', [SubscriptionController::class, 'transactions'])->name('subscriptions.transactions');
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::get('/transactions', [SubscriptionController::class, 'transactions'])->name('transactions.index');
    Route::get('/revenue', [SubscriptionController::class, 'revenue'])->name('revenue');

    Route::resource('subscription-plans', SubscriptionPlanController::class)->names('subscription-plans');
    Route::post('/subscription-plans/{subscriptionPlan}/toggle', [SubscriptionPlanController::class, 'toggleActive'])->name('subscription-plans.toggle');
    Route::post('/subscription-plans/reorder', [SubscriptionPlanController::class, 'reorder'])->name('subscription-plans.reorder');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/comments', [PostController::class, 'comments'])->name('comments.index');

    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/ads-accounts', [CampaignController::class, 'adsAccounts'])->name('ads-accounts.index');
    Route::get('/adsets', [CampaignController::class, 'adsets'])->name('adsets.index');
    Route::get('/ads', [CampaignController::class, 'ads'])->name('ads.index');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/scores', [AnalyticsController::class, 'scores'])->name('analytics.scores');
    Route::get('/analytics/page-scores', [AnalyticsController::class, 'pageScores'])->name('analytics.page-scores');
    Route::get('/analytics/demographics', [AnalyticsController::class, 'demographics'])->name('analytics.demographics');
    Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/preview', [ReportController::class, 'preview'])->name('reports.preview');
    Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/{conversation}', [InboxController::class, 'show'])->name('inbox.show');
    Route::get('/messages', [InboxController::class, 'messages'])->name('messages.index');
    Route::get('/inbox-stats', [InboxController::class, 'stats'])->name('inbox.stats');

    Route::resource('knowledge-base', KnowledgeBaseController::class)->names('knowledge-base');

    Route::resource('webhooks', WebhookController::class);
    Route::post('/webhooks/{webhook}/test', [WebhookController::class, 'test'])->name('webhooks.test');
    Route::post('/webhooks/{webhook}/toggle', [WebhookController::class, 'toggleActive'])->name('webhooks.toggle');
    Route::post('/webhooks/{webhook}/regenerate-secret', [WebhookController::class, 'regenerateSecret'])->name('webhooks.regenerate-secret');

    Route::get('/compliance', [ComplianceController::class, 'index'])->name('compliance.index');
    Route::get('/compliance/policies', [ComplianceController::class, 'policies'])->name('compliance.policies');
    Route::get('/compliance/policies/create', [ComplianceController::class, 'createPolicy'])->name('compliance.policies.create');
    Route::post('/compliance/policies', [ComplianceController::class, 'storePolicy'])->name('compliance.policies.store');
    Route::get('/compliance/policies/{policy}/edit', [ComplianceController::class, 'editPolicy'])->name('compliance.policies.edit');
    Route::put('/compliance/policies/{policy}', [ComplianceController::class, 'updatePolicy'])->name('compliance.policies.update');
    Route::get('/compliance/data-requests', [ComplianceController::class, 'dataRequests'])->name('compliance.data-requests');
    Route::get('/compliance/data-requests/{dataRequest}', [ComplianceController::class, 'showDataRequest'])->name('compliance.show-data-request');
    Route::post('/compliance/data-requests/{dataRequest}/process', [ComplianceController::class, 'processDataRequest'])->name('compliance.process-data-request');
    Route::get('/compliance/retention-rules', [ComplianceController::class, 'retentionRules'])->name('compliance.retention-rules');
    Route::post('/compliance/retention-rules', [ComplianceController::class, 'storeRetentionRule'])->name('compliance.store-retention-rule');
    Route::put('/compliance/retention-rules/{rule}', [ComplianceController::class, 'updateRetentionRule'])->name('compliance.update-retention-rule');

    Route::get('/api-keys', [ApiKeyController::class, 'index'])->name('api-keys.index');
    Route::post('/api-keys/update', [ApiKeyController::class, 'update'])->name('api-keys.update');
    Route::post('/api-keys/test', [ApiKeyController::class, 'test'])->name('api-keys.test');
    Route::post('/api-keys/delete', [ApiKeyController::class, 'delete'])->name('api-keys.delete');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [SettingsController::class, 'create'])->name('settings.create');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

    Route::get('/settings/email', [SettingsController::class, 'emailConfig'])->name('settings.email');
    Route::put('/settings/email', [SettingsController::class, 'updateEmailConfig'])->name('settings.email.update');
    Route::post('/settings/email/test', [SettingsController::class, 'testEmailConfig'])->name('settings.email.test');

    Route::get('/settings/stripe', [SettingsController::class, 'stripeConfig'])->name('settings.stripe');
    Route::put('/settings/stripe', [SettingsController::class, 'updateStripeConfig'])->name('settings.stripe.update');
    Route::post('/settings/stripe/test', [SettingsController::class, 'testStripeConfig'])->name('settings.stripe.test');

    Route::get('/settings/webhooks', [SettingsController::class, 'webhooksConfig'])->name('settings.webhooks');
    Route::put('/settings/webhooks', [SettingsController::class, 'updateWebhooksConfig'])->name('settings.webhooks.update');

    Route::get('/settings/notifications', [SettingsController::class, 'notificationConfig'])->name('settings.notifications');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotificationConfig'])->name('settings.notifications.update');

    Route::get('/settings/{group}/edit', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{group}', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings/{setting}', [SettingsController::class, 'destroy'])->name('settings.destroy');

    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/stats', [ActivityController::class, 'stats'])->name('activities.stats');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/stats', [NotificationController::class, 'stats'])->name('notifications.stats');
    Route::get('/notifications/scheduler-status', [NotificationController::class, 'schedulerStatus'])->name('notifications.scheduler-status');
    Route::post('/notifications/run-now', [NotificationController::class, 'runNow'])->name('notifications.run-now');
    Route::post('/notifications/bulk-retry', [NotificationController::class, 'bulkRetry'])->name('notifications.bulk-retry');
    Route::post('/notifications/bulk-cancel', [NotificationController::class, 'bulkCancel'])->name('notifications.bulk-cancel');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/retry', [NotificationController::class, 'retry'])->name('notifications.retry');
    Route::post('/notifications/{notification}/cancel', [NotificationController::class, 'cancel'])->name('notifications.cancel');

    Route::get('/billing/overview', [BillingController::class, 'overview'])->name('billing.overview');
    Route::get('/billing/payments', [BillingController::class, 'payments'])->name('billing.payments');
    Route::get('/billing/activity-logs', [BillingController::class, 'activityLogs'])->name('billing.activity-logs');
    Route::get('/billing/activity-logs/{log}', [BillingController::class, 'showLog'])->name('billing.show-log');
    Route::get('/billing/payment-methods', [BillingController::class, 'paymentMethods'])->name('billing.payment-methods');
    Route::get('/billing/dunning', [BillingController::class, 'dunning'])->name('billing.dunning');
    Route::get('/billing/notifications', [BillingController::class, 'notifications'])->name('billing.notifications');

    Route::middleware('permission:view_admin_users')->group(function () {
        Route::get('/admin-users', [AdminUserController::class, 'index'])->name('admin-users.index');
        Route::get('/admin-users/create', [AdminUserController::class, 'create'])->name('admin-users.create')->middleware('permission:manage_admin_users');
        Route::post('/admin-users', [AdminUserController::class, 'store'])->name('admin-users.store')->middleware('permission:manage_admin_users');
        Route::get('/admin-users/{adminUser}/edit', [AdminUserController::class, 'edit'])->name('admin-users.edit')->middleware('permission:manage_admin_users');
        Route::put('/admin-users/{adminUser}', [AdminUserController::class, 'update'])->name('admin-users.update')->middleware('permission:manage_admin_users');
        Route::delete('/admin-users/{adminUser}', [AdminUserController::class, 'destroy'])->name('admin-users.destroy')->middleware('permission:manage_admin_users');
        Route::post('/admin-users/{adminUser}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin-users.toggle-status')->middleware('permission:manage_admin_users');
    });

    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/audit-logs/sessions', [AuditLogController::class, 'sessions'])->name('audit-logs.sessions');
    Route::get('/audit-logs/my-sessions', [AuditLogController::class, 'mySessions'])->name('audit-logs.my-sessions');
    Route::get('/audit-logs/security', [AuditLogController::class, 'securityOverview'])->name('audit-logs.security');
    Route::post('/audit-logs/sessions/{session}/revoke', [AuditLogController::class, 'revokeSession'])->name('audit-logs.revoke-session');
    Route::post('/audit-logs/revoke-all-other', [AuditLogController::class, 'revokeAllOtherSessions'])->name('audit-logs.revoke-all-other');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
});