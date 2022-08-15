<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppSetting::insert([
            [
                'key' => 'name',
                'value' => 'Laragram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'language',
                'value' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'credit',
                'value' => 'NewAgeDevs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'credit_text',
                'value' => 'All Right Reserved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'credit_url',
                'value' => 'https://www.newagedevs.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'allow_registration',
                'value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'notification_sound',
                'value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_settings',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'no_image',
                'value' => 'images/no_image_available.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'logo_sm',
                'value' => 'images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'logo_light',
                'value' => 'images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'logo_dark',
                'value' => 'images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'favicon',
                'value' => 'images/favicon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'document_max_size_limit',
                'value' => '5000000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'image_max_size_limit',
                'value' => '5000000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'email',
                'value' => 'support@newagedevs.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'phone',
                'value' => '01628755880',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'address',
                'value' => 'Mirpur - 12, Dhaka - 1216, Bangladesh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
