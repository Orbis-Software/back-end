<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::where('legal_name', 'Orbis Software Ltd')->firstOrFail();

        $admin = User::updateOrCreate(
            ['email' => 'admin@orbissoftware.dev'],
            [
                'name'       => 'Admin User',
                'password'   => Hash::make('password'),
                'company_id' => $company->id,
            ]
        );

        $admin->assignRole('admin');

        $ops = User::updateOrCreate(
            ['email' => 'ops@orbissoftware.dev'],
            [
                'name'       => 'Operations Staff',
                'password'   => Hash::make('password'),
                'company_id' => $company->id,
            ]
        );

        $ops->assignRole('ops');
    }
}
