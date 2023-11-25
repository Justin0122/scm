<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $permission = Permission::create(['name' => 'seeTelescope']);
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo($permission);

        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('password'),
        ])->assignRole($role);

    }
}
