<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotspot_vouchers', function (Blueprint $table) {
            $table->foreignId('reseller_id')
                ->nullable()
                ->after('created_by')
                ->constrained('resellers')
                ->nullOnDelete();

            $table->index(['reseller_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('hotspot_vouchers', function (Blueprint $table) {
            $table->dropForeign(['reseller_id']);
            $table->dropIndex(['reseller_id', 'status']);
            $table->dropColumn('reseller_id');
        });
    }
};
