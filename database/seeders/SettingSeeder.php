<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->firstOrCreate([], [
            'site_name_ka' => 'მართლმსაჯულება და კანონი',
            'site_name_en' => 'Justice and Law',
            'issn' => '1512-259X',
            'copyright_text_ka' => '© '.date('Y').' მართლმსაჯულება და კანონი. ყველა უფლება დაცულია.',
            'copyright_text_en' => '© '.date('Y').' Justice and Law. All rights reserved.',
            'phone' => null,
            'email' => null,
            'address_ka' => null,
            'address_en' => null,
            'map_embed_url' => null,
            'facebook_url' => null,
        ]);
    }
}
