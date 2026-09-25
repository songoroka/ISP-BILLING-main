<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_lists', function (Blueprint $table) {
            $table->string('validity_type', 20)
                ->nullable()
                ->after('service_type');

            $table->string('validity_duration', 50)
                ->nullable()
                ->after('validity_type');
        });
    }

    public function down(): void
    {
        Schema::table('package_lists', function (Blueprint $table) {
            $table->dropColumn([
                'validity_type',
                'validity_duration',
            ]);
        });
    }
};
