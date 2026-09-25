<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('must_change_password')->default(false)->after('password');
            $table->boolean('demo_access')->default(false)->after('must_change_password');
        });

        // Existing reseller accounts were created by an administrator and should
        // complete a password change before using the portal.
        DB::table('users')
            ->whereIn('id', function ($query) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('roles.name', 'Reseller')
                    ->where('model_has_roles.model_type', 'App\Models\User');
            })
            ->update(['must_change_password' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['must_change_password', 'demo_access']);
        });
    }
};
