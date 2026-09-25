<?php

namespace Database\Seeders;

use App\Models\MainSiteData;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaults = [
            'site_name' => 'SKYTECH INFRANET',
            'site_title' => 'SKYTECH INFRANET',
            'theme_preset' => 'fintech',
            'theme_name' => 'skytech_blue_green',
            'theme_primary_color' => '#006DB6',
            'theme_accent_color' => '#00A878',
            'theme_card_style' => 'glass',
            'theme_border_radius' => '20px',
        ];

        foreach ($defaults as $key => $value) {
            if (MainSiteData::getValue($key) === null) {
                MainSiteData::setValue($key, $value);
            }
        }
        // User::factory(10)->withPersonalTeam()->create();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminSeeder::class,
            ResellerModuleSeeder::class,
            SmsTemplateSeeder::class,
            // DefaultSettingsTableSeeder::class,
            // ProductSeeder::class,
        ]);
    }
}
