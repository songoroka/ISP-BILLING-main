<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = Permission::query()->pluck('name')->all();
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $hotelUser = Role::firstOrCreate(['name' => 'Hotel User', 'guard_name' => 'web']);
        $superAdmin->syncPermissions($allPermissions);
        $admin->syncPermissions(array_values(array_diff($allPermissions, [
            'hotel-view-guests', 'hotel-create-guest', 'hotel-edit-guest', 'hotel-delete-guest', 'hotel-print-voucher',
        ])));
        $manager->syncPermissions(['create-web-content','edit-web-content','delete-web-content']);
        $hotelUser->syncPermissions([
            'hotel-view-guests',
            'hotel-create-guest',
            'hotel-edit-guest',
            'hotel-delete-guest',
            'hotel-print-voucher',
        ]);
    }
}
