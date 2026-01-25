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

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'digitalmart.mag@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'super_admin', // အစ်ကို့ database structure အပေါ် မူတည်ပါတယ်
        ]);

        // 1. Category များ ဆောက်တည်မယ်
        $categories = ['Electronics', 'Fashion', 'Phone & Accessories', 'Computer', 'Shoes'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // 2. Category ごとに異なるダミー商品を追加

        // Electronics Category
        $electronicsProducts = [
            ['name' => 'Smart LED TV 43 inch', 'price' => 350000],
            ['name' => 'Wireless Headphones Pro', 'price' => 45000],
            ['name' => 'Digital Camera HD', 'price' => 120000],
            ['name' => 'USB Hub 7-Port', 'price' => 12000],
            ['name' => 'Power Bank 20000mAh', 'price' => 25000],
        ];

        // Fashion Category
        $fashionProducts = [
            ['name' => 'Casual T-Shirt', 'price' => 8000],
            ['name' => 'Denim Jeans Blue', 'price' => 22000],
            ['name' => 'Cotton Hoodie', 'price' => 35000],
            ['name' => 'Formal Shirt White', 'price' => 18000],
            ['name' => 'Shorts Summer', 'price' => 12000],
        ];

        // Phone & Accessories Category
        $phoneProducts = [
            ['name' => 'iPhone 15 Case', 'price' => 15000],
            ['name' => 'Samsung Phone Screen Protector', 'price' => 5000],
            ['name' => 'Fast Charger 65W', 'price' => 32000],
            ['name' => 'USB-C Cable 2m', 'price' => 8000],
            ['name' => 'Phone Stand Metal', 'price' => 10000],
        ];

        // Computer Category
        $computerProducts = [
            ['name' => 'Wireless Mouse Pro', 'price' => 18000],
            ['name' => 'Mechanical Keyboard RGB', 'price' => 65000],
            ['name' => 'Monitor Stand Adjustable', 'price' => 25000],
            ['name' => 'Laptop Cooling Pad', 'price' => 22000],
            ['name' => 'SSD 512GB', 'price' => 45000],
        ];

        // Shoes Category
        $shoesProducts = [
            ['name' => 'Running Shoes Sport', 'price' => 38000],
            ['name' => 'Casual Sneakers', 'price' => 28000],
            ['name' => 'Formal Dress Shoes', 'price' => 42000],
            ['name' => 'Sandals Beach', 'price' => 12000],
            ['name' => 'Boots Winter Leather', 'price' => 55000],
        ];

        // Save products by category
        $categoryData = [
            1 => $electronicsProducts,
            2 => $fashionProducts,
            3 => $phoneProducts,
            4 => $computerProducts,
            5 => $shoesProducts,
        ];

        foreach ($categoryData as $categoryId => $products) {
            foreach ($products as $product) {
                Product::create([
                    'name' => $product['name'],
                    'code_number' => $this->generateUniqueCode($categoryId),
                    'price' => $product['price'],
                    'stock' => rand(5, 50),
                    'image' => 'https://placehold.co/600x400?text=' . urlencode($product['name']),
                    'category_id' => $categoryId,
                ]);
            }
        }

        // 3. ပြင်ဆင်ခဲ့သည့် အော်ဒါ ကြမ်းများ ထည့်သွင်းမယ်
        for ($i = 1; $i <= 5; $i++) {
            Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'customer_name' => 'Test Customer ' . $i,
                'customer_phone' => '09' . rand(100000000, 999999999),
                'total_amount' => rand(50000, 500000),
                'status' => ['pending', 'confirmed', 'completed', 'cancelled'][rand(0, 3)],
            ]);
        }
    }

    private function generateUniqueCode($categoryId)
    {
        $category = Category::find($categoryId);
        $prefix = strtoupper(substr($category->name, 0, 3));
        $count = Product::where('category_id', $categoryId)->count() + 1;
        return $prefix . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
