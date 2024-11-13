<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'description' => 'All about the latest technology trends.'],
            ['name' => 'Health & Wellness', 'description' => 'Tips and advice on living a healthy life.'],
            ['name' => 'Travel', 'description' => 'Travel guides, tips, and destinations.'],
            ['name' => 'Finance', 'description' => 'Managing money, investments, and financial advice.'],
            ['name' => 'Lifestyle', 'description' => 'Lifestyle and culture content for daily inspiration.'],
        ];

        foreach ($categories as $category) {
            DB::table('blog_categories')->insert($category);
        }
    }
}
