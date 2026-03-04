<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@footsy.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Create regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@footsy.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create products
        $products = [
            [
                'name' => 'Urban Runner Pro',
                'price' => 129.99,
                'description' => 'Premium running shoes with advanced cushioning technology. Perfect for long-distance runs and daily training.',
                'category' => 'men',
                'brand' => 'Nike',
                'colors' => ['Black', 'White', 'Blue'],
                'sizes' => [7, 8, 9, 10, 11, 12],
                'images' => ['https://images.unsplash.com/photo-1695459468644-717c8ae17eed?w=800&q=80'],
                'stock' => 50,
                'featured' => true,
            ],
            [
                'name' => 'Classic Leather Boots',
                'price' => 189.99,
                'description' => 'Handcrafted leather boots with premium finish. Durable and stylish for any occasion.',
                'category' => 'men',
                'brand' => 'Timberland',
                'colors' => ['Brown', 'Black'],
                'sizes' => [8, 9, 10, 11, 12],
                'images' => ['https://images.unsplash.com/photo-1495579891230-9592c8ba6708?w=800&q=80'],
                'stock' => 30,
                'featured' => true,
            ],
            [
                'name' => 'White Minimalist Sneakers',
                'price' => 89.99,
                'description' => 'Clean and versatile white sneakers. Perfect for casual everyday wear.',
                'category' => 'women',
                'brand' => 'Adidas',
                'colors' => ['White', 'Cream'],
                'sizes' => [5, 6, 7, 8, 9, 10],
                'images' => ['https://images.unsplash.com/photo-1759542890353-35f5568c1c90?w=800&q=80'],
                'stock' => 45,
                'featured' => true,
            ],
            [
                'name' => 'Elegant High Heels',
                'price' => 149.99,
                'description' => 'Sophisticated high heels for special occasions. Comfortable and stylish design.',
                'category' => 'women',
                'brand' => 'Steve Madden',
                'colors' => ['Black', 'Red', 'Nude'],
                'sizes' => [5, 6, 7, 8, 9],
                'images' => ['https://images.unsplash.com/photo-1554238113-6d3dbed5cf55?w=800&q=80'],
                'stock' => 25,
                'featured' => false,
            ],
            [
                'name' => 'Summer Comfort Sandals',
                'price' => 59.99,
                'description' => 'Breathable summer sandals with excellent comfort. Ideal for warm weather.',
                'category' => 'women',
                'brand' => 'Birkenstock',
                'colors' => ['Tan', 'Black', 'White'],
                'sizes' => [5, 6, 7, 8, 9, 10],
                'images' => ['https://images.unsplash.com/photo-1743591684800-c8cfba557087?w=800&q=80'],
                'stock' => 60,
                'featured' => false,
            ],
            [
                'name' => 'Kids Adventure Sneakers',
                'price' => 49.99,
                'description' => 'Colorful and durable sneakers for active kids. Comfortable fit for all-day play.',
                'category' => 'kids',
                'brand' => 'Skechers',
                'colors' => ['Blue', 'Pink', 'Green'],
                'sizes' => [1, 2, 3, 4, 5, 6],
                'images' => ['https://images.unsplash.com/photo-1583979365152-173a8f14181b?w=800&q=80'],
                'stock' => 40,
                'featured' => true,
            ],
            [
                'name' => 'Athletic Performance Trainers',
                'price' => 159.99,
                'description' => 'High-performance training shoes for serious athletes. Maximum support and stability.',
                'category' => 'men',
                'brand' => 'Nike',
                'colors' => ['Black', 'Red', 'White'],
                'sizes' => [8, 9, 10, 11, 12, 13],
                'images' => ['https://images.unsplash.com/photo-1579528542333-4148f1769c35?w=800&q=80'],
                'stock' => 35,
                'featured' => false,
            ],
            [
                'name' => 'Formal Oxford Dress Shoes',
                'price' => 199.99,
                'description' => 'Classic oxford dress shoes for professional settings. Premium leather construction.',
                'category' => 'men',
                'brand' => 'Clarks',
                'colors' => ['Black', 'Brown'],
                'sizes' => [7, 8, 9, 10, 11, 12],
                'images' => ['https://images.unsplash.com/photo-1689620400465-cd736688c41f?w=800&q=80'],
                'stock' => 20,
                'featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

