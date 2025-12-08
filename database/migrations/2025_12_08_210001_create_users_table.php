<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            return;
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('firstName', 200);
            $table->string('lastName', 200);
            $table->string('email', 250)->unique();
            $table->string('bio', 255)->nullable();
            $table->string('company', 255)->nullable();
            $table->string('jobTitle', 255)->nullable();
            $table->string('userLocation', 255)->nullable();
            $table->string('userWebsite', 255)->nullable();
            $table->string('password', 250);
            $table->enum('role', ['Superadmin', 'Admin', 'User'])->default('User');
            $table->string('profileImage', 255)->nullable();
            $table->string('timeZone', 255)->nullable();
            $table->string('otp', 100)->nullable();
            $table->timestamp('otpGeneratedAt')->nullable();
            $table->string('resetPasswordToken', 255)->nullable();
            $table->string('resetPasswordRequestTime', 255)->nullable();
            $table->longText('onboardGoal')->nullable();
            $table->longText('onboardRole')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->enum('onboard_status', ['0', '1'])->default('0');
            $table->string('stripe_customer_id', 255)->nullable();
            $table->string('billing_name', 255)->nullable();
            $table->string('billing_email', 255)->nullable();
            $table->string('billing_phone', 50)->nullable();
            $table->string('billing_address_line1', 255)->nullable();
            $table->string('billing_address_line2', 255)->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_state', 100)->nullable();
            $table->string('billing_postal_code', 20)->nullable();
            $table->string('billing_country', 2)->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->string('tax_id_type', 20)->nullable();
            $table->string('default_payment_method_id', 255)->nullable();
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('updatedAt')->useCurrent();

            $table->index('uuid');
            $table->index('stripe_customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
