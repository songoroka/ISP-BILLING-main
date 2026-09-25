<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('router_lists', function (Blueprint $table) {
            $table->string('portal_token', 128)
                ->nullable()
                ->unique()
                ->after('router_name');
        });
    }

    public function down(): void
    {
        Schema::table('router_lists', function (Blueprint $table) {
            $table->dropUnique(['portal_token']);
            $table->dropColumn('portal_token');
        });
    }
};
