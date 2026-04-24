<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
{
    $roles = [
        ['id' => 1, 'role_name' => 'Admin', 'permissions' => 'all'],
        ['id' => 2, 'role_name' => 'Manager', 'permissions' => 'inventory,reports'],
        ['id' => 3, 'role_name' => 'Cashier', 'permissions' => 'sales'],
    ];

    foreach ($roles as $role) {
        \App\Models\UserRoles::updateOrCreate(['id' => $role['id']], $role);
    }
}
}
