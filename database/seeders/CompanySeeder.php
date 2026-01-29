<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::updateOrCreate(
            [
                // Unique identity
                'legal_name' => 'Orbis Software Ltd',
            ],
            [
                // Identity
                'trading_name'        => 'Orbis Software',
                'registration_number' => 'ORBIS-001',

                // Addresses
                'registered_address'  => 'United Kingdom',
                'operational_address' => 'United Kingdom',

                // Preferences
                'default_currency'    => 'GBP',
                'language'            => 'en',               // ✅ ADD
                'time_zone'           => 'Europe/London',

                // Branding
                'logo'                => null,               // ✅ ADD (placeholder)

                // Status
                'status'              => 'active',
            ]
        );
    }
}
