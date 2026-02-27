<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class DefaultIntegrationsSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $existing = (array) SystemSetting::getValue('integrations', []);

        $gaAccounts = (array) data_get($existing, 'ga_accounts', []);
        $gtmAccounts = (array) data_get($existing, 'gtm_accounts', []);

        if (count($gaAccounts) < 1) {
            $gaAccounts = [
                [
                    'name' => 'Lau Paradise Adventure',
                    'id' => '385714587',
                ],
            ];
        }

        if (count($gtmAccounts) < 1) {
            $gtmAccounts = [
                [
                    'name' => 'LAU Paradise Adventure',
                    'id' => '6341293708',
                ],
            ];
        }

        $value = array_merge($existing, [
            'ga_accounts' => $gaAccounts,
            'gtm_accounts' => $gtmAccounts,
        ]);

        SystemSetting::setValue('integrations', $value);
    }
}
