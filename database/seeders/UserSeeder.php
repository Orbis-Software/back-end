<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@orbis-software.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'ops@orbis-software.com'],
            [
                'name' => 'Operations Staff',
                'password' => Hash::make('password'),
            ]
        );
    }
}
