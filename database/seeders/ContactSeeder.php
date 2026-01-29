<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                ['address' => 'Rotterdam, NL', 'country' => 'NL', 'eori' => 'NL009988776655', 'credit_limit' => null, 'currency_preference' => 'EUR'],
                ['address' => 'Hamburg, DE', 'country' => 'DE', 'eori' => 'DE554433221100', 'credit_limit' => null, 'currency_preference' => 'EUR'],
                ['address' => 'Antwerp, BE', 'country' => 'BE', 'eori' => 'BE667788990011', 'credit_limit' => null, 'currency_preference' => 'EUR'],
            ],

            'road_haulier' => [
                ['address' => 'Birmingham, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'GBP'],
                ['address' => 'Leeds, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'GBP'],
                ['address' => 'Bristol, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'GBP'],
            ],

            'airline' => [
                ['address' => 'Heathrow Airport, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'GBP'],
                ['address' => 'Schiphol Airport, NL', 'country' => 'NL', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'EUR'],
                ['address' => 'Frankfurt Airport, DE', 'country' => 'DE', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'EUR'],
            ],

            'rail_operator' => [
                ['address' => 'London Rail Terminal, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'GBP'],
                ['address' => 'Paris Rail Hub, FR', 'country' => 'FR', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'EUR'],
                ['address' => 'Madrid Rail Terminal, ES', 'country' => 'ES', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'EUR'],
            ],

            'shipping_line' => [
                ['address' => 'Felixstowe Port, UK', 'country' => 'GB', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'GBP'],
                ['address' => 'Port of Rotterdam, NL', 'country' => 'NL', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'EUR'],
                ['address' => 'Port of Hamburg, DE', 'country' => 'DE', 'eori' => null, 'credit_limit' => null, 'currency_preference' => 'EUR'],
            ],
        ];

        foreach ($seed as $type => $rows) {
            foreach ($rows as $data) {

                // ✅ Contact uniqueness (since no contact_type column anymore)
                $uniqueKey = [
                    'company_id' => $company->id,
                    'address'    => $data['address'],
                ];

                // ✅ Create/Update contact WITHOUT contact_type
                $contact = Contact::updateOrCreate($uniqueKey, array_merge($data, [
                    'company_id' => $company->id,
                    'status'     => 'active',
                ]));

                // ✅ Insert type into pivot
                DB::table('contact_contact_types')->updateOrInsert(
                    [
                        'contact_id'   => $contact->id,
                        'contact_type' => $type,
                    ],
                    [
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                // ✅ Optional: seed one contact person per contact (nice UX for UI)
                DB::table('contact_people')->updateOrInsert(
                    [
                        'contact_id' => $contact->id,
                        'email'      => $this->fakeEmail($type, $contact->id),
                    ],
                    [
                        'name'       => $this->fakeName($type),
                        'phone'      => $this->fakePhone($type),
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    private function fakeEmail(string $type, int $id): string
    {
        $typeSlug = str_replace('_', '-', $type);
        return "contact{$id}@{$typeSlug}.example.com";
    }

    private function fakeName(string $type): string
    {
        return match ($type) {
            'customer'      => 'Accounts Team',
            'supplier'      => 'Billing Desk',
            'road_haulier'  => 'Dispatch Office',
            'airline'       => 'Cargo Sales',
            'rail_operator' => 'Rail Ops Desk',
            'shipping_line' => 'Port Operations',
            default         => 'Main Contact',
        };
    }

    private function fakePhone(string $type): string
    {
        // simple stable dummy phone numbers
        return match ($type) {
            'customer'      => '+44 20 7000 0001',
            'supplier'      => '+49 30 7000 0002',
            'road_haulier'  => '+44 121 7000 0003',
            'airline'       => '+44 20 7000 0004',
            'rail_operator' => '+33 1 7000 0005',
            'shipping_line' => '+31 10 7000 0006',
            default         => '+44 20 7000 0000',
        };
    }
}
