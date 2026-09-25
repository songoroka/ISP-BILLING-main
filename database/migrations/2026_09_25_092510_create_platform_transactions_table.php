<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_transactions', function (Blueprint $table) {
            $table->id();

            // Super Admin account receiving the platform fee.
            $table->foreignId('super_admin_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // One platform-fee transaction per Hotspot sale.
            // This unique constraint provides idempotency.
            $table->foreignId('hotspot_sale_id')
                ->unique()
                ->constrained('hotspot_sales')
                ->cascadeOnDelete();

            // Reseller who owns the voucher/sale, when applicable.
            $table->foreignId('reseller_id')
                ->nullable()
                ->constrained('resellers')
                ->nullOnDelete();

            $table->string('type', 50)->default('platform_fee');

            // Original customer purchase amount.
            $table->decimal('gross_amount', 14, 2);

            // Platform fee percentage.
            $table->decimal('fee_percentage', 5, 2)->default(10.00);

            // Amount transferred to the platform/Super Admin ledger.
            $table->decimal('fee_amount', 14, 2);

            $table->char('currency', 3)->default('TZS');

            $table->string('description')->nullable();

            $table->timestamps();

            $table->index(['super_admin_user_id', 'created_at']);
            $table->index(['reseller_id', 'created_at']);
            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_transactions');
    }
};
