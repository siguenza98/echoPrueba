<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $inventory_manager = Role::create(['name' => 'inventory_manager']);
        $accountant = Role::create(['name' => 'accountant']);
        $client = Role::create(['name' => 'client']);

        Permission::create(['name' => 'home'])->syncRoles([$admin, $inventory_manager, $accountant, $client]);
        Permission::create(['name' => 'users'])->assignRole($admin);
        Permission::create(['name' => 'stock'])->syncRoles([$admin, $inventory_manager]);
        Permission::create(['name' => 'accounting'])->syncRoles([$admin, $accountant]);
        Permission::create(['name' => 'online_store'])->syncRoles([$client]);

    }
}
