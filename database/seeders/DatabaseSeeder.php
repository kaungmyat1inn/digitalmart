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

        // Create Categories
        $categories = [
            ['name' => 'Smartphones', 'slug' => 'smartphones'],
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Tablets', 'slug' => 'tablets'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
            ['name' => 'Audio', 'slug' => 'audio'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Products for each category
        $products = [
            // Smartphones (Category 1)
            ['category_id' => 1, 'name' => 'iPhone 15 Pro Max', 'code_number' => 'IP15PM-001', 'price' => 1499000, 'stock' => 10, 'image' => 'products/iphone15promax.jpg', 'group_id' => 'IP15PM', 'supplier' => 'Apple Distributor', 'description' => 'Latest iPhone with A17 Pro chip, 48MP camera system.'],
            ['category_id' => 1, 'name' => 'iPhone 15 Pro', 'code_number' => 'IP15P-002', 'price' => 1299000, 'stock' => 15, 'image' => 'products/iphone15pro.jpg', 'group_id' => 'IP15P', 'supplier' => 'Apple Distributor', 'description' => 'iPhone 15 Pro with titanium design.'],
            ['category_id' => 1, 'name' => 'Samsung Galaxy S24 Ultra', 'code_number' => 'SG24U-003', 'price' => 1399000, 'stock' => 8, 'image' => 'products/galaxys24ultra.jpg', 'group_id' => 'SG24U', 'supplier' => 'Samsung Myanmar', 'description' => 'Galaxy S24 Ultra with built-in S Pen.'],
            ['category_id' => 1, 'name' => 'Samsung Galaxy Z Fold 5', 'code_number' => 'SGZF5-004', 'price' => 1699000, 'stock' => 5, 'image' => 'products/galaxyzfold5.jpg', 'group_id' => 'SGZF5', 'supplier' => 'Samsung Myanmar', 'description' => 'Foldable smartphone with large display.'],
            ['category_id' => 1, 'name' => 'Xiaomi 14 Ultra', 'code_number' => 'XM14U-005', 'price' => 999000, 'stock' => 12, 'image' => 'products/xiaomi14ultra.jpg', 'group_id' => 'XM14U', 'supplier' => 'Xiaomi Myanmar', 'description' => 'Leica camera system, powerful performance.'],

            // Laptops (Category 2)
            ['category_id' => 2, 'name' => 'MacBook Pro 14" M3', 'code_number' => 'MBP14M3-006', 'price' => 2899000, 'stock' => 6, 'image' => 'products/macbookpro14.jpg', 'group_id' => 'MBP14', 'supplier' => 'Apple Distributor', 'description' => '14-inch MacBook Pro with M3 Pro chip.'],
            ['category_id' => 2, 'name' => 'MacBook Air M2', 'code_number' => 'MBA-M2-007', 'price' => 1499000, 'stock' => 10, 'image' => 'products/macbookairm2.jpg', 'group_id' => 'MBA', 'supplier' => 'Apple Distributor', 'description' => 'Thin and light laptop with M2 chip.'],
            ['category_id' => 2, 'name' => 'Dell XPS 15', 'code_number' => 'DELLXPS15-008', 'price' => 2199000, 'stock' => 8, 'image' => 'products/dellxps15.jpg', 'group_id' => 'DELLXPS', 'supplier' => 'Dell Myanmar', 'description' => 'Premium Windows laptop with InfinityEdge display.'],
            ['category_id' => 2, 'name' => 'HP Spectre x360', 'code_number' => 'HPSPEC-009', 'price' => 1799000, 'stock' => 7, 'image' => 'products/hpspectre.jpg', 'group_id' => 'HPSPEC', 'supplier' => 'HP Myanmar', 'description' => '2-in-1 convertible laptop.'],
            ['category_id' => 2, 'name' => 'ASUS ROG Zephyrus G14', 'code_number' => 'ASUSROG-010', 'price' => 1999000, 'stock' => 5, 'image' => 'products/asuszephyrus.jpg', 'group_id' => 'ASUSROG', 'supplier' => 'ASUS Myanmar', 'description' => 'Gaming laptop with Ryzen processor.'],

            // Tablets (Category 3)
            ['category_id' => 3, 'name' => 'iPad Pro 12.9" M2', 'code_number' => 'IPADPRO12-011', 'price' => 1299000, 'stock' => 10, 'image' => 'products/ipadpro12.jpg', 'group_id' => 'IPADPRO', 'supplier' => 'Apple Distributor', 'description' => '12.9-inch iPad Pro with M2 chip.'],
            ['category_id' => 3, 'name' => 'iPad Air M2', 'code_number' => 'IPADAIR-012', 'price' => 799000, 'stock' => 15, 'image' => 'products/ipadair.jpg', 'group_id' => 'IPADAIR', 'supplier' => 'Apple Distributor', 'description' => 'iPad Air with M2 chip, 10.9-inch display.'],
            ['category_id' => 3, 'name' => 'Samsung Galaxy Tab S9 Ultra', 'code_number' => 'SGTABSU-013', 'price' => 1199000, 'stock' => 8, 'image' => 'products/galaxytabs9.jpg', 'group_id' => 'SGTABS', 'supplier' => 'Samsung Myanmar', 'description' => '14.6-inch AMOLED display tablet.'],
            ['category_id' => 3, 'name' => 'Xiaomi Pad 6', 'code_number' => 'XMPAD6-014', 'price' => 449000, 'stock' => 20, 'image' => 'products/xiaomipad6.jpg', 'group_id' => 'XMPAD', 'supplier' => 'Xiaomi Myanmar', 'description' => '11-inch display, great value tablet.'],
            ['category_id' => 3, 'name' => 'Lenovo Tab P11 Pro', 'code_number' => 'LENP11-015', 'price' => 699000, 'stock' => 12, 'image' => 'products/lenovotab.jpg', 'group_id' => 'LENP11', 'supplier' => 'Lenovo Myanmar', 'description' => '11.5-inch OLED display tablet.'],

            // Accessories (Category 4)
            ['category_id' => 4, 'name' => 'AirPods Pro 2nd Gen', 'code_number' => 'AIRP2-016', 'price' => 349000, 'stock' => 30, 'image' => 'products/airpodspro2.jpg', 'group_id' => 'AIRP', 'supplier' => 'Apple Distributor', 'description' => 'Active noise cancellation earbuds.'],
            ['category_id' => 4, 'name' => 'Apple Watch Series 9', 'code_number' => 'AWS9-017', 'price' => 499000, 'stock' => 20, 'image' => 'products/applewatch9.jpg', 'group_id' => 'AWS', 'supplier' => 'Apple Distributor', 'description' => 'GPS + Cellular, 45mm.'],
            ['category_id' => 4, 'name' => 'Samsung Galaxy Watch 6', 'code_number' => 'SGW6-018', 'price' => 399000, 'stock' => 25, 'image' => 'products/galaxywatch6.jpg', 'group_id' => 'SGW', 'supplier' => 'Samsung Myanmar', 'description' => '44mm smartwatch with health monitoring.'],
            ['category_id' => 4, 'name' => 'Anker PowerBank 20000mAh', 'code_number' => 'ANKPB-019', 'price' => 59000, 'stock' => 50, 'image' => 'products/ankerpowerbank.jpg', 'group_id' => 'ANKPB', 'supplier' => 'Anker Official', 'description' => 'High capacity portable charger.'],
            ['category_id' => 4, 'name' => 'USB-C Hub 7-in-1', 'code_number' => 'USBC-020', 'price' => 45000, 'stock' => 40, 'image' => 'products/usbchub.jpg', 'group_id' => 'USBC', 'supplier' => 'Tech Accessories', 'description' => 'Multi-port adapter for laptops.'],

            // Audio (Category 5)
            ['category_id' => 5, 'name' => 'Sony WH-1000XM5', 'code_number' => 'SONYWH-021', 'price' => 449000, 'stock' => 20, 'image' => 'products/sonywh1000xm5.jpg', 'group_id' => 'SONYWH', 'supplier' => 'Sony Myanmar', 'description' => 'Industry-leading noise canceling headphones.'],
            ['category_id' => 5, 'name' => 'Bose QC Ultra', 'code_number' => 'BOSEQC-022', 'price' => 429000, 'stock' => 18, 'image' => 'products/boseqcultra.jpg', 'group_id' => 'BOSEQC', 'supplier' => 'Bose Myanmar', 'description' => 'Premium noise canceling headphones.'],
            ['category_id' => 5, 'name' => 'JBL Flip 6', 'code_number' => 'JBLF6-023', 'price' => 129000, 'stock' => 35, 'image' => 'products/jblflip6.jpg', 'group_id' => 'JBLF', 'supplier' => 'JBL Myanmar', 'description' => 'Portable Bluetooth speaker.'],
            ['category_id' => 5, 'name' => 'Marshall Middleton', 'code_number' => 'MARSH-024', 'price' => 349000, 'stock' => 15, 'image' => 'products/marshallmiddleton.jpg', 'group_id' => 'MARSH', 'supplier' => 'Marshall Myanmar', 'description' => 'Portable speaker with iconic Marshall sound.'],
            ['category_id' => 5, 'name' => 'Shure MV7 Podcast Mic', 'code_number' => 'SHURE-025', 'price' => 299000, 'stock' => 12, 'image' => 'products/shuremv7.jpg', 'group_id' => 'SHURE', 'supplier' => 'Shure Myanmar', 'description' => 'Hybrid USB/XLR microphone for podcasting.'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Dummy data seeded successfully!');
        $this->command->info('Created 1 admin user, 5 categories, and 25 products.');
    }
}
