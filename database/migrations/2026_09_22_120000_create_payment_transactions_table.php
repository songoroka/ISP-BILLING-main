<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('provider', 40); // selcom, mpesa_tz, etc.
            $table->string('channel', 60)->nullable();
            $table->string('customer_unique_id')->index();
            $table->string('merchant_reference', 120)->unique();
            $table->string('provider_transaction_id', 120)->nullable()->index();
            $table->string('provider_reference', 120)->nullable();
            $table->string('phone', 30)->nullable();
            $table->decimal('amount', 14, 2);
            $table->char('currency', 3)->default('TZS');
            $table->string('status', 30)->default('pending')->index();
            $table->string('failure_code', 80)->nullable();
            $table->text('failure_message')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
