<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users; // Ensure this matches your model name
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account (Role ID 1)
        Users::create([
            'username' => 'admin_user',
            'email'    => 'admin@supplycore.com',
            'password' => Hash::make('password123'), // Securely hashed
            'role_id'  => 1, 
        ]);

        // Manager Account (Role ID 2)
        Users::create([
            'username' => 'manager_user',
            'email'    => 'manager@supplycore.com',
            'password' => Hash::make('password123'),
            'role_id'  => 2,
        ]);

        // Cashier Account (Role ID 3)
        Users::create([
            'username' => 'cashier_user',
            'email'    => 'cashier@supplycore.com',
            'password' => Hash::make('password123'),
            'role_id'  => 3,
        ]);
    }
}