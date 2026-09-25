<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotspot_activation_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hotspot_purchase_request_id')
                ->constrained('hotspot_purchase_requests')
                ->cascadeOnDelete();

            $table->string('router_name');
            $table->string('mac_address', 64);

            $table->unsignedInteger('attempt_number')->default(1);

            $table->string('status', 30)->default('pending');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('error_message')->nullable();

            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();

            $table->timestamps();

            $table->index(
                ['hotspot_purchase_request_id', 'attempt_number'],
                'hotspot_activation_request_attempt_idx'
            );

            $table->index(
                ['router_name', 'mac_address', 'status'],
                'hotspot_activation_router_status_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotspot_activation_attempts');
    }
};
