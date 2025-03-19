<?php

namespace Database\Seeders;

use App\Models\Admin\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1, // Fresh Produce
                'name' => 'Organic Apples',
                'slug' => 'organic-apples',
                'description' => 'Fresh and organic apples, grown without pesticides.',
                'price' => '3.99',
                'image' => 'images/organic-apples.jpg',
                'featured' => true,
            ],
            [
                'category_id' => 2, // Dairy & Eggs
                'name' => 'Free-Range Eggs',
                'slug' => 'free-range-eggs',
                'description' => 'Eggs from free-range chickens, packed with nutrients.',
                'price' => '4.99',
                'image' => 'images/free-range-eggs.jpg',
                'featured' => false,
            ],
            [
                'category_id' => 3, // Bakery
                'name' => 'Fresh Bread',
                'slug' => 'fresh-bread',
                'description' => 'Warm, soft, and freshly baked bread, perfect for any meal.',
                'price' => '2.49',
                'image' => 'images/fresh-bread.jpg',
                'featured' => true,
            ],
            [
                'category_id' => 4, // Beverages
                'name' => 'Organic Green Tea',
                'slug' => 'organic-green-tea',
                'description' => 'Relax and unwind with a cup of organic green tea.',
                'price' => '5.99',
                'image' => 'images/organic-green-tea.jpg',
                'featured' => false,
            ],
            [
                'category_id' => 5, // Snacks
                'name' => 'Chips & Salsa',
                'slug' => 'chips-salsa',
                'description' => 'Crunchy chips with delicious homemade salsa.',
                'price' => '3.49',
                'image' => 'images/chips-salsa.jpg',
                'featured' => true,
            ],
            [
                'category_id' => 6, // Frozen Foods
                'name' => 'Frozen Pizza',
                'slug' => 'frozen-pizza',
                'description' => 'Frozen pizza with a delicious mix of fresh toppings.',
                'price' => '7.99',
                'image' => 'images/frozen-pizza.jpg',
                'featured' => false,
            ],
            [
                'category_id' => 7, // Health & Wellness
                'name' => 'Vitamin C Supplements',
                'slug' => 'vitamin-c-supplements',
                'description' => 'Boost your immune system with these vitamin C supplements.',
                'price' => '12.99',
                'image' => 'images/vitamin-c.jpg',
                'featured' => true,
            ],
            [
                'category_id' => 8, // Household Essentials
                'name' => 'All-Purpose Cleaner',
                'slug' => 'all-purpose-cleaner',
                'description' => 'Effective cleaner for all surfaces in your home.',
                'price' => '5.99',
                'image' => 'images/all-purpose-cleaner.jpg',
                'featured' => false,
            ],
            [
                'category_id' => 9, // Cleaning Supplies
                'name' => 'Disinfecting Wipes',
                'slug' => 'disinfecting-wipes',
                'description' => 'Convenient disinfecting wipes for fast and easy cleaning.',
                'price' => '3.49',
                'image' => 'images/disinfecting-wipes.jpg',
                'featured' => false,
            ],
            [
                'category_id' => 10, // Baby Care
                'name' => 'Diapers',
                'slug' => 'diapers',
                'description' => 'Soft and absorbent diapers for your little one.',
                'price' => '9.99',
                'image' => 'images/diapers.jpg',
                'featured' => false,
            ],
            [
                'category_id' => 11, // Personal Care
                'name' => 'Organic Shampoo',
                'slug' => 'organic-shampoo',
                'description' => 'Shampoo made with organic ingredients for healthy hair.',
                'price' => '6.99',
                'image' => 'images/organic-shampoo.jpg',
                'featured' => true,
            ],
            [
                'category_id' => 12, // Pet Supplies
                'name' => 'Pet Food',
                'slug' => 'pet-food',
                'description' => 'High-quality food for your furry friends.',
                'price' => '15.99',
                'image' => 'images/pet-food.jpg',
                'featured' => false,
            ],
            [
                'category_id' => 13, // Organic Products
                'name' => 'Organic Granola',
                'slug' => 'organic-granola',
                'description' => 'A healthy and delicious organic granola snack.',
                'price' => '4.49',
                'image' => 'images/organic-granola.jpg',
                'featured' => true,
            ],
            [
                'category_id' => 14, // Gourmet Foods
                'name' => 'Gourmet Chocolate',
                'slug' => 'gourmet-chocolate',
                'description' => 'Decadent gourmet chocolate, perfect for any occasion.',
                'price' => '8.99',
                'image' => 'images/gourmet-chocolate.jpg',
                'featured' => false,
            ],
            // Additional products can go here, ensuring they are linked to a category
        ];

        // Insert products into the database
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
