<?php

use App\Models\MainSiteData;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        MainSiteData::setValue('site_phone', '+255622221464/+255754448446');
        MainSiteData::setValue('help_desk_phone', '+255622221464/+255754448446');
        MainSiteData::setValue('site_name', 'SKYTECH INFRANET');
        MainSiteData::setValue('site_title', 'SKYTECH INFRANET');
    }
    public function down(): void {}
};
