<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample categories for FreshCart with featured categories
        $categories = [
            [
                'name' => 'Fresh Produce',
                'slug' => 'fresh-produce',
                'image' => 'images/fresh-produce.jpg',
                'featured' => true,
            ],
            [
                'name' => 'Dairy & Eggs',
                'slug' => 'dairy-eggs',
                'image' => 'images/dairy-eggs.jpg',
                'featured' => false,
            ],
            [
                'name' => 'Bakery',
                'slug' => 'bakery',
                'image' => 'images/bakery.jpg',
                'featured' => true,
            ],
            [
                'name' => 'Beverages',
                'slug' => 'beverages',
                'image' => 'images/beverages.jpg',
                'featured' => false,
            ],
            [
                'name' => 'Snacks',
                'slug' => 'snacks',
                'image' => 'images/snacks.jpg',
                'featured' => true,
            ],
            [
                'name' => 'Frozen Foods',
                'slug' => 'frozen-foods',
                'image' => 'images/frozen-foods.jpg',
                'featured' => false,
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'image' => 'images/health-wellness.jpg',
                'featured' => true,
            ],
            [
                'name' => 'Household Essentials',
                'slug' => 'household-essentials',
                'image' => 'images/household-essentials.jpg',
                'featured' => false,
            ],
            [
                'name' => 'Cleaning Supplies',
                'slug' => 'cleaning-supplies',
                'image' => 'images/cleaning-supplies.jpg',
                'featured' => false,
            ],
            [
                'name' => 'Baby Care',
                'slug' => 'baby-care',
                'image' => 'images/baby-care.jpg',
                'featured' => false,
            ],
            [
                'name' => 'Personal Care',
                'slug' => 'personal-care',
                'image' => 'images/personal-care.jpg',
                'featured' => true,
            ],
            [
                'name' => 'Pet Supplies',
                'slug' => 'pet-supplies',
                'image' => 'images/pet-supplies.jpg',
                'featured' => false,
            ],
            [
                'name' => 'Organic Products',
                'slug' => 'organic-products',
                'image' => 'images/organic-products.jpg',
                'featured' => true,
            ],
            [
                'name' => 'Gourmet Foods',
                'slug' => 'gourmet-foods',
                'image' => 'images/gourmet-foods.jpg',
                'featured' => false,
            ],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }

    }
}
