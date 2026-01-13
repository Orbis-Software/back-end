<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@orbis.test',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Operations Staff',
            'email' => 'ops@orbis.test',
            'password' => Hash::make('password'),
        ]);
    }
}
