<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('package_lists', function (Blueprint $table) {
            $table->boolean('ttl_mangle_enabled')->default(false)->after('push_to_mikrotik');
            $table->unsignedSmallInteger('ttl_value')->nullable()->after('ttl_mangle_enabled');
            $table->string('ttl_chain')->default('postrouting')->after('ttl_value');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_lists', function (Blueprint $table) {
            $table->dropColumn(['ttl_mangle_enabled', 'ttl_value', 'ttl_chain']);
        });
    }
};
