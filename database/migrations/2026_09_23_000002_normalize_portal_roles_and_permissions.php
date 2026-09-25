<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $requiredPermissions = [
            'create-reseller', 'push-customers', 'site-setup', 'manage-tickets',
            'view-tickets', 'view-user-role', 'payment-collection-edit',
            'payment-collection-invoice', 'payment-collection-report',
        ];
        foreach ($requiredPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        $permissions = Permission::query()->pluck('name')->all();
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Reseller', 'guard_name' => 'web']);
        $superAdmin->syncPermissions($permissions);
        $admin->syncPermissions($permissions);
        $customer = Role::where('name', 'Customer')->where('guard_name', 'web')->first();
        if ($customer) { $customer->users()->detach(); $customer->delete(); }
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
    public function down(): void {}
};
