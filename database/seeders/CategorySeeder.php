<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'category_name' => 'Action',
        ]);

        Category::create([
            'category_name' => 'Adventure',
        ]);

        Category::create([
            'category_name' => 'RPG',
        ]);

        Category::create([
            'category_name' => 'Strategy',
        ]);

        Category::create([
            'category_name' => 'Sports',
        ]);

        Category::create([
            'category_name' => 'Racing',
        ]);
    }
}
