<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Seed User Roles (Must match your Middleware logic)
        $roles = [
            ['id' => 1, 'role_name' => 'Admin', 'permissions' => 'all', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'role_name' => 'Manager', 'permissions' => 'inventory,sales,reports', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'role_name' => 'Cashier', 'permissions' => 'sales,returns', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('user_roles')->insert($roles);

        // 2. Seed Users
        // Using 'password' for everyone so you can easily log in and test different accounts
        $defaultPassword = Hash::make('password'); 
        
        $users = [
            ['username' => 'gene_admin', 'password' => $defaultPassword, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['username' => 'wendy_mgr', 'password' => $defaultPassword, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['username' => 'justine_cash', 'password' => $defaultPassword, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['username' => 'lance_cash', 'password' => $defaultPassword, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('users')->insert($users);

        // 3. Seed Categories
        $categories = [
            ['id' => 1, 'category_name' => 'Microcontrollers', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'category_name' => 'Sensors', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'category_name' => 'Peripherals', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('categories')->insert($categories);

        // 4. Seed Suppliers
        $suppliers = [
            ['id' => 1, 'company_name' => 'TechSource Electronics', 'contact_person' => 'Alice Johnson', 'phone' => '555-0100', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'company_name' => 'Global Hardware Inc.', 'contact_person' => 'Bob Smith', 'phone' => '555-0200', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('suppliers')->insert($suppliers);

        // 5. Seed Products
        $products = [
            [
                'name' => 'ESP32 Development Board',
                'category_id' => 1,
                'supplier_id' => 1,
                'stock_level' => 150,
                'current_price' => 12.99,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Ultrasonic Flow Sensor',
                'category_id' => 2,
                'supplier_id' => 1,
                'stock_level' => 85,
                'current_price' => 24.50,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Mechanical Keyboard (Linear Switches)',
                'category_id' => 3,
                'supplier_id' => 2,
                'stock_level' => 40,
                'current_price' => 89.99,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'High-Speed Gaming Mouse',
                'category_id' => 3,
                'supplier_id' => 2,
                'stock_level' => 60,
                'current_price' => 49.99,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];
        DB::table('products')->insert($products);
    }
}