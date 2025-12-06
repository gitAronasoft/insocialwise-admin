<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'trial_reminder_sent')) {
                $table->boolean('trial_reminder_sent')->default(false)->after('metadata')->comment('Whether trial ending reminder was sent');
            }
            if (!Schema::hasColumn('subscriptions', 'trial_reminder_sent_at')) {
                $table->dateTime('trial_reminder_sent_at')->nullable()->after('trial_reminder_sent')->comment('When trial reminder was sent');
            }
            if (!Schema::hasColumn('subscriptions', 'renewal_reminder_sent')) {
                $table->boolean('renewal_reminder_sent')->default(false)->after('trial_reminder_sent_at')->comment('Whether renewal reminder was sent');
            }
            if (!Schema::hasColumn('subscriptions', 'renewal_reminder_sent_at')) {
                $table->dateTime('renewal_reminder_sent_at')->nullable()->after('renewal_reminder_sent')->comment('When renewal reminder was sent');
            }
            if (!Schema::hasColumn('subscriptions', 'synced_at')) {
                $table->dateTime('synced_at')->nullable()->after('renewal_reminder_sent_at')->comment('Last sync with Stripe');
            }
            if (!Schema::hasColumn('subscriptions', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('price_id')->comment('Local subscription plan ID');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $columns = ['trial_reminder_sent', 'trial_reminder_sent_at', 'renewal_reminder_sent', 'renewal_reminder_sent_at', 'synced_at', 'plan_id'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('subscriptions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
