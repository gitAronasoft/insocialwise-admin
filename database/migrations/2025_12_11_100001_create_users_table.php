<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->char('uuid', 36)->nullable();
                $table->string('firstname', 200);
                $table->string('lastname', 200);
                $table->string('email', 250)->unique();
                $table->string('bio', 255)->nullable();
                $table->string('company', 255)->nullable();
                $table->string('jobtitle', 255)->nullable();
                $table->string('userlocation', 255)->nullable();
                $table->string('userwebsite', 255)->nullable();
                $table->string('password', 250);
                $table->string('role', 50)->default('User');
                $table->string('profileimage', 255)->nullable();
                $table->string('timezone', 255)->nullable();
                $table->string('otp', 100)->nullable();
                $table->timestampTz('otp_generated_at')->nullable();
                $table->string('reset_password_token', 255)->nullable();
                $table->string('reset_password_request_time', 255)->nullable();
                $table->text('onboard_goal')->nullable();
                $table->text('onboard_role')->nullable();
                $table->smallInteger('status')->default(0);
                $table->smallInteger('onboard_status')->default(0);
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
                $table->timestamps();
                
                $table->index('uuid');
                $table->index('email');
                $table->index('stripe_customer_id');
            });
        }
    }

    public function down(): void
    {
    }
};
