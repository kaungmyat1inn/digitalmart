<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'digitalmart.mag@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
            'subscription_start' => now(),
            'subscription_end' => now()->addYears(10),
        ]);
    }
}
