<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::updateOrCreate(
            ['legal_name' => 'Orbis Software Ltd'],
            [
                'trading_name'        => 'Orbis Software',
                'registration_number' => 'ORBIS-001',
                'registered_address'  => 'United Kingdom',
                'operational_address' => 'United Kingdom',
                'default_currency'    => 'GBP',
                'time_zone'           => 'Europe/London',
                'status'              => 'active',
            ]
        );
    }
}
