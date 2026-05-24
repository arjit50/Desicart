<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Review;
use App\Models\InventoryLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $buyerRole = Role::firstOrCreate(['name' => 'buyer', 'guard_name' => 'web']);
        $shopkeeperRole = Role::firstOrCreate(['name' => 'shopkeeper', 'guard_name' => 'web']);

        // 2. Create Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@grocify.com'],
            [
                'name' => 'Grocify Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        $customer = User::firstOrCreate(
            ['email' => 'customer@grocify.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $customer->assignRole($buyerRole);

        // 3. Create Addresses
        Address::firstOrCreate(
            ['user_id' => $customer->id, 'type' => 'shipping', 'is_default' => true],
            [
                'name' => 'John Doe',
                'phone' => '123-456-7890',
                'address_line_1' => '123 Main Street',
                'address_line_2' => 'Apt 4B',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'country' => 'United States',
            ]
        );

        Address::firstOrCreate(
            ['user_id' => $customer->id, 'type' => 'billing', 'is_default' => false],
            [
                'name' => 'John Doe',
                'phone' => '123-456-7890',
                'address_line_1' => '123 Main Street',
                'address_line_2' => 'Apt 4B',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'country' => 'United States',
            ]
        );

        // 4. Create Brands
        $brandsData = [
            ['name' => 'FreshFarm', 'slug' => 'freshfarm', 'image' => '/images/brands/freshfarm.webp'],
            ['name' => 'NatureChoice', 'slug' => 'naturechoice', 'image' => '/images/brands/naturechoice.webp'],
            ['name' => 'DairyPure', 'slug' => 'dairypure', 'image' => '/images/brands/dairypure.webp'],
            ['name' => 'BeverageCo', 'slug' => 'beverageco', 'image' => '/images/brands/beverageco.webp'],
            ['name' => 'SnackTime', 'slug' => 'snacktime', 'image' => '/images/brands/snacktime.webp'],
            ['name' => 'BakerStreet', 'slug' => 'bakerstreet', 'image' => '/images/brands/bakerstreet.webp'],
            ['name' => 'FrostyFoods', 'slug' => 'frostyfoods', 'image' => '/images/brands/frostyfoods.webp'],
            ['name' => 'CleanHome', 'slug' => 'cleanhome', 'image' => '/images/brands/cleanhome.webp'],
        ];

        $brands = [];
        foreach ($brandsData as $b) {
            $brands[$b['slug']] = Brand::firstOrCreate(['slug' => $b['slug']], $b);
        }

        // 5. Create Categories
        $categoriesData = [
            ['name' => 'Fruits', 'slug' => 'fruits', 'image' => 'https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Vegetables', 'slug' => 'vegetables', 'image' => 'https://images.unsplash.com/photo-1566385101042-1a010c129fa6?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Dairy', 'slug' => 'dairy', 'image' => 'https://images.unsplash.com/photo-1628088062854-d1870b4553da?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Beverages', 'slug' => 'beverages', 'image' => 'https://images.unsplash.com/photo-1527960656366-ee2a999e32e6?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Snacks', 'slug' => 'snacks', 'image' => 'https://images.unsplash.com/photo-1599490659213-e2b9527ab087?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Bakery', 'slug' => 'bakery', 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Frozen Foods', 'slug' => 'frozen-foods', 'image' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Household Items', 'slug' => 'household-items', 'image' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?auto=format&fit=crop&w=600&q=80'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // 6. Create Products and Images
        $productsData = [
            // Fruits
            [
                'name' => 'Fresh Red Apples',
                'description' => 'Crisp, sweet, and juicy red apples sourced from local orchards. Rich in fiber and vitamins.',
                'price' => 2.99,
                'discount_price' => 2.49,
                'rating' => 4.5,
                'stock' => 120,
                'brand_slug' => 'freshfarm',
                'category_slug' => 'fruits',
                'image_url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Organic Bananas',
                'description' => 'Sweet and creamy organic bananas. Perfect for a quick energy boost or breakfast smoothies.',
                'price' => 1.99,
                'discount_price' => null,
                'rating' => 4.8,
                'stock' => 180,
                'brand_slug' => 'naturechoice',
                'category_slug' => 'fruits',
                'image_url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Sweet Strawberries',
                'description' => 'Bright red, plump, and delicious strawberries. Great for snacking, salads, or desserts.',
                'price' => 4.99,
                'discount_price' => 3.99,
                'rating' => 4.2,
                'stock' => 90,
                'brand_slug' => 'freshfarm',
                'category_slug' => 'fruits',
                'image_url' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?auto=format&fit=crop&w=600&q=80'
            ],

            // Vegetables
            [
                'name' => 'Fresh Broccoli',
                'description' => 'Nutrient-rich, vibrant green broccoli crowns. Perfect for steaming, roasting, or stir-frying.',
                'price' => 1.49,
                'discount_price' => null,
                'rating' => 4.6,
                'stock' => 75,
                'brand_slug' => 'freshfarm',
                'category_slug' => 'vegetables',
                'image_url' => 'https://images.unsplash.com/photo-1584270354949-c26b0d5b4a0c?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Organic Carrots',
                'description' => 'Freshly harvested, sweet organic carrots. High in beta-carotene and great for juicing or snacking.',
                'price' => 2.29,
                'discount_price' => null,
                'rating' => 4.7,
                'stock' => 110,
                'brand_slug' => 'naturechoice',
                'category_slug' => 'vegetables',
                'image_url' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Roma Tomatoes',
                'description' => 'Firm and meaty Roma tomatoes. Ideal for making sauces, salads, or slicing on sandwiches.',
                'price' => 2.99,
                'discount_price' => 1.99,
                'rating' => 4.3,
                'stock' => 140,
                'brand_slug' => 'freshfarm',
                'category_slug' => 'vegetables',
                'image_url' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=600&q=80'
            ],

            // Dairy
            [
                'name' => 'Whole Milk 1 Gallon',
                'description' => 'Pasteurized and homogenized whole milk from local dairy farms. Creamy and full of vitamin D.',
                'price' => 3.89,
                'discount_price' => null,
                'rating' => 4.9,
                'stock' => 60,
                'brand_slug' => 'dairypure',
                'category_slug' => 'dairy',
                'image_url' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Organic Greek Yogurt',
                'description' => 'Rich, thick, and packed with protein. Unsweetened Greek yogurt made with organic milk.',
                'price' => 5.49,
                'discount_price' => 4.79,
                'rating' => 4.4,
                'stock' => 45,
                'brand_slug' => 'dairypure',
                'category_slug' => 'dairy',
                'image_url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Cheddar Cheese Block',
                'description' => 'Sharp and aged white cheddar cheese block. Perfect for slicing, grating, or snacking.',
                'price' => 4.29,
                'discount_price' => null,
                'rating' => 4.7,
                'stock' => 85,
                'brand_slug' => 'dairypure',
                'category_slug' => 'dairy',
                'image_url' => 'https://images.unsplash.com/photo-1486299267070-83823f5448dd?auto=format&fit=crop&w=600&q=80'
            ],

            // Beverages
            [
                'name' => 'Fresh Orange Juice',
                'description' => '100% pure squeezed orange juice with pulp. High in Vitamin C, no added sugars.',
                'price' => 4.99,
                'discount_price' => 4.29,
                'rating' => 4.8,
                'stock' => 50,
                'brand_slug' => 'beverageco',
                'category_slug' => 'beverages',
                'image_url' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Sparkling Water 12-Pack',
                'description' => 'Refreshing lime-flavored sparkling water cans. Zero calories, zero sweeteners.',
                'price' => 5.99,
                'discount_price' => null,
                'rating' => 4.5,
                'stock' => 100,
                'brand_slug' => 'beverageco',
                'category_slug' => 'beverages',
                'image_url' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?auto=format&fit=crop&w=600&q=80'
            ],

            // Snacks
            [
                'name' => 'Potato Chips Classic',
                'description' => 'Crispy, salted classic potato chips. The perfect crunchy companion for any gathering.',
                'price' => 3.49,
                'discount_price' => 2.99,
                'rating' => 4.1,
                'stock' => 150,
                'brand_slug' => 'snacktime',
                'category_slug' => 'snacks',
                'image_url' => 'https://images.unsplash.com/photo-1566478989037-eec170784d0b?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Mixed Roasted Nuts Jar',
                'description' => 'A premium mix of almonds, cashews, walnuts, and pecans, lightly roasted and salted.',
                'price' => 8.99,
                'discount_price' => null,
                'rating' => 4.6,
                'stock' => 70,
                'brand_slug' => 'snacktime',
                'category_slug' => 'snacks',
                'image_url' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80'
            ],

            // Bakery
            [
                'name' => 'Sourdough Bread',
                'description' => 'Freshly baked artisanal sourdough bread. Golden, crispy crust with a soft, airy interior.',
                'price' => 3.99,
                'discount_price' => null,
                'rating' => 4.9,
                'stock' => 30,
                'brand_slug' => 'bakerstreet',
                'category_slug' => 'bakery',
                'image_url' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Fresh Butter Croissants',
                'description' => 'Golden-brown, flaky, and buttery croissants. Best enjoyed warm with coffee.',
                'price' => 4.99,
                'discount_price' => 3.99,
                'rating' => 4.7,
                'stock' => 40,
                'brand_slug' => 'bakerstreet',
                'category_slug' => 'bakery',
                'image_url' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80'
            ],

            // Frozen
            [
                'name' => 'Frozen Pizza Supreme',
                'description' => 'Crispy crust topped with rich tomato sauce, pepperoni, sausage, bell peppers, and cheese.',
                'price' => 6.99,
                'discount_price' => 5.99,
                'rating' => 4.3,
                'stock' => 65,
                'brand_slug' => 'frostyfoods',
                'category_slug' => 'frozen-foods',
                'image_url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=600&q=80'
            ],

            // Household
            [
                'name' => 'Liquid Dish Soap',
                'description' => 'Tough on grease but gentle on hands. Fresh lemon scent, leaves dishes sparkling clean.',
                'price' => 2.99,
                'discount_price' => null,
                'rating' => 4.4,
                'stock' => 95,
                'brand_slug' => 'cleanhome',
                'category_slug' => 'household-items',
                'image_url' => 'https://images.unsplash.com/photo-1607006342411-1a90e6377708?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'name' => 'Paper Towels 6-Roll',
                'description' => 'Ultra-absorbent and strong paper towels. Perfect for cleaning spills and wiping surfaces.',
                'price' => 7.49,
                'discount_price' => 6.49,
                'rating' => 4.6,
                'stock' => 80,
                'brand_slug' => 'cleanhome',
                'category_slug' => 'household-items',
                'image_url' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=600&q=80'
            ]
        ];

        foreach ($productsData as $pData) {
            $brand = $brands[$pData['brand_slug']] ?? null;
            $category = $categories[$pData['category_slug']] ?? null;

            if ($brand && $category) {
                $product = Product::firstOrCreate(
                    ['slug' => Str::slug($pData['name'])],
                    [
                        'name' => $pData['name'],
                        'description' => $pData['description'],
                        'price' => $pData['price'],
                        'discount_price' => $pData['discount_price'],
                        'rating' => $pData['rating'],
                        'stock' => $pData['stock'],
                        'brand_id' => $brand->id,
                        'category_id' => $category->id
                    ]
                );

                // Add primary image
                ProductImage::firstOrCreate(
                    ['product_id' => $product->id, 'url' => $pData['image_url']],
                    ['is_primary' => true]
                );

                // Create initial inventory log
                InventoryLog::firstOrCreate(
                    ['product_id' => $product->id, 'type' => 'restock', 'quantity' => $product->stock],
                    [
                        'user_id' => $admin->id,
                        'description' => 'Initial stock load via seeder'
                    ]
                );

                // Add a dummy review for this product
                Review::firstOrCreate(
                    ['product_id' => $product->id, 'user_id' => $customer->id],
                    [
                        'rating' => rand(4, 5),
                        'comment' => 'Excellent quality product, fast delivery and very fresh!'
                    ]
                );
            }
        }

        // 7. Seed Coupons
        Coupon::firstOrCreate(
            ['code' => 'SAVE10'],
            [
                'type' => 'percentage',
                'value' => 10.00,
                'min_order_amount' => 20.00,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'GROCIFY20'],
            [
                'type' => 'fixed',
                'value' => 20.00,
                'min_order_amount' => 100.00,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'WELCOME5'],
            [
                'type' => 'fixed',
                'value' => 5.00,
                'min_order_amount' => 10.00,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ]
        );
    }
}
