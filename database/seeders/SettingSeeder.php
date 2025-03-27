<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Jasa Amanah'],
            ['key' => 'site_logo', 'value' => 'logos/default.png'],
            ['key' => 'contact_email', 'value' => 'admin@jasaamanah.com'],
            ['key' => 'contact_phone', 'value' => '+62 812-3456-7890'],
            ['key' => 'contact_address', 'value' => 'Jl. Sudirman No.10, Jakarta'],
            ['key' => 'about_us', 'value' => 'Jasa Amanah adalah perusahaan layanan profesional...'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/jasaamanah'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/jasaamanah'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/jasaamanah'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
