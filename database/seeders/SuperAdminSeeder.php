<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'rohan9222@gmail.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('rohan9222@gmail.com')]
        );
        $superAdmin->assignRole('Super Admin');
    }
}
