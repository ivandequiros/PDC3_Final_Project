<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRoles; // Ensure this matches your model name

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Admin'],
            ['role_name' => 'Manager'],
            ['role_name' => 'Cashier'],
        ];

        foreach ($roles as $role) {
            UserRoles::create($role);
        }
    }
}