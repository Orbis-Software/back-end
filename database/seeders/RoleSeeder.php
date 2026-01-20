<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles/permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Cache::flush();

        $roles = [
            'super-admin',
            'admin',
            'ops',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web', // change to 'api' if you use api guard for auth
            ]);
        }
    }
}
