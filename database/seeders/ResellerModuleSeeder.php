<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ResellerModuleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Reseller', 'guard_name' => 'web']);
    }
}
