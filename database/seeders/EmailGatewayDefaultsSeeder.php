<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class EmailGatewayDefaultsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'mail_host' => env('MAIL_HOST'),
            'mail_port' => env('MAIL_PORT'),
            'mail_username' => env('MAIL_USERNAME'),
            'mail_password' => env('MAIL_PASSWORD'),
            'mail_encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME', config('app.name', 'System')),
        ];

        foreach ($defaults as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $existing = SystemSetting::getValue($key);
            if ($existing === null || $existing === '') {
                SystemSetting::setValue($key, $value);
            }
        }
    }
}
