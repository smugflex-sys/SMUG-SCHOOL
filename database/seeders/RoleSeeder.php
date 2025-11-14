<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['Admin', 'Student', 'Teacher', 'Parent', 'Accountant', 'Librarian'];

        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}