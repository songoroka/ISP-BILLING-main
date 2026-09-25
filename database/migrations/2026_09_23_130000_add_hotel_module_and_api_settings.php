<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('hotel_guests')) {
            Schema::create('hotel_guests', function (Blueprint $table) {
                $table->id();
                $table->string('voucher_number')->unique();
                $table->string('guest_name');
                $table->string('gender')->nullable();
                $table->string('nationality')->nullable();
                $table->string('document_type')->nullable();
                $table->string('document_number')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('room_number')->nullable();
                $table->dateTime('check_in');
                $table->dateTime('check_out')->nullable();
                $table->unsignedInteger('adults')->default(1);
                $table->unsignedInteger('children')->default(0);
                $table->string('purpose')->nullable();
                $table->text('notes')->nullable();
                $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
                $table->index(['guest_name', 'check_in']);
                $table->index('document_number');
            });
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $permissions = [
            'hotel-view-guests',
            'hotel-create-guest',
            'hotel-edit-guest',
            'hotel-delete-guest',
            'hotel-print-voucher',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $hotelRole = Role::firstOrCreate(['name' => 'Hotel User', 'guard_name' => 'web']);
        $hotelRole->syncPermissions($permissions);

        // Hotel access is an explicit Super Admin privilege. Existing Admin users
        // must not inherit the hotel module merely because Admin previously had all permissions.
        $admin = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        if ($admin) {
            $admin->revokePermissionTo($permissions);
        }

        // Keep the deployment color aligned with the blue/green SKYTECH plan when
        // no custom theme has been configured yet. Existing custom colors are kept.
        $defaults = [
            'theme_primary_color' => '#006DB6',
            'theme_accent_color' => '#00A878',
            'portal_primary_color' => '#006DB6',
            'portal_accent_color' => '#00A878',
            'theme_name' => 'skytech_blue_green',
            'theme_preset' => 'fintech',
            'api_integrations' => [],
            'hotel_voucher_prefix' => 'HTL-',
            'hotel_name' => 'SKYTECH INFRANET Hotel Module',
            'hotel_voucher_footer' => 'Guest registration voucher. No billing information is included.',
        ];

        if (Schema::hasTable('main_site_data')) {
            foreach ($defaults as $type => $value) {
                $exists = \DB::table('main_site_data')->where('type', $type)->exists();
                if (! $exists) {
                    \DB::table('main_site_data')->insert([
                        'type' => $type,
                        'value' => is_array($value) ? json_encode($value) : $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('hotel_guests')) {
            Schema::drop('hotel_guests');
        }

        $role = Role::where('name', 'Hotel User')->where('guard_name', 'web')->first();
        if ($role) {
            $role->delete();
        }

        Permission::whereIn('name', [
            'hotel-view-guests',
            'hotel-create-guest',
            'hotel-edit-guest',
            'hotel-delete-guest',
            'hotel-print-voucher',
        ])->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
