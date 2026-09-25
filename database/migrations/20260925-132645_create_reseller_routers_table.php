<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reseller_routers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reseller_id')
                ->constrained('resellers')
                ->cascadeOnDelete();

            $table->foreignId('router_id')
                ->constrained('router_lists')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['reseller_id', 'router_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reseller_routers');
    }
};
