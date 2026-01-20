<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::where('legal_name', 'Orbis Software Ltd')->firstOrFail();

        $seed = [
            'customer' => [
                ['address' => 'London, UK', 'country' => 'GB', 'eori' => 'GB123456789000', 'credit_limit' => 50000, 'currency_preference' => 'GBP'],
                ['address' => 'Manchester, UK', 'country' => 'GB', 'eori' => 'GB987654321000', 'credit_limit' => 25000, 'currency_preference' => 'GBP'],
                ['address' => 'Dublin, IE', 'country' => 'IE', 'eori' => 'IE112233445566', 'credit_limit' => 15000, 'currency_preference' => 'EUR'],
            ],

            'supplier' => [
                ['address' => 'Rotterdam, NL', 'country' => 'NL', 'eori' => 'NL009988776655', 'credit_limit' => 0, 'currency_preference' => 'EUR'],
                ['address' => 'Hamburg, DE', 'country' => 'DE', 'eori' => 'DE554433221100', 'credit_limit' => 0, 'currency_preference' => 'EUR'],
                ['address' => 'Antwerp, BE', 'country' => 'BE', 'eori' => 'BE667788990011', 'credit_limit' => 0, 'currency_preference' => 'EUR'],
            ],

            'road_haulier' => [
                ['address' => 'Birmingham, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'GBP'],
                ['address' => 'Leeds, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'GBP'],
                ['address' => 'Bristol, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'GBP'],
            ],

            'airline' => [
                ['address' => 'Heathrow Airport, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'GBP'],
                ['address' => 'Schiphol Airport, NL', 'country' => 'NL', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'EUR'],
                ['address' => 'Frankfurt Airport, DE', 'country' => 'DE', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'EUR'],
            ],

            'rail_operator' => [
                ['address' => 'London Rail Terminal, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'GBP'],
                ['address' => 'Paris Rail Hub, FR', 'country' => 'FR', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'EUR'],
                ['address' => 'Madrid Rail Terminal, ES', 'country' => 'ES', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'EUR'],
            ],

            'shipping_line' => [
                ['address' => 'Felixstowe Port, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'GBP'],
                ['address' => 'Port of Rotterdam, NL', 'country' => 'NL', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'EUR'],
                ['address' => 'Port of Hamburg, DE', 'country' => 'DE', 'eori' => null, 'credit_limit' => 0, 'currency_preference' => 'EUR'],
            ],
        ];

        foreach ($seed as $type => $rows) {
            foreach ($rows as $i => $data) {
                // Create a stable unique key for updateOrCreate
                $uniqueKey = [
                    'company_id' => $company->id,
                    'contact_type' => $type,
                    'address' => $data['address'],
                ];

                Contact::updateOrCreate($uniqueKey, array_merge($data, [
                    'company_id' => $company->id,
                    'contact_type' => $type,
                    'status' => 'active',
                ]));
            }
        }
    }
}
