<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 1',
            'slug' => 'category_1',
        ]);
        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 2',
            'slug' => 'category_2',
        ]);

        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 1.1',
            'slug' => 'category_1_1',
            'parent_id' => 1,
        ]);


        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 3',
            'slug' => 'category_3',
        ]);

        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 3.1',
            'slug' => 'category_3_1',
            'parent_id' => 4,
        ]);

        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 3.2',
            'slug' => 'category_3_2',
            'parent_id' => 4,
        ]);

        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 3.2.1',
            'slug' => 'category_3_2_1',
            'parent_id' => 6,
        ]);

        Category::updateOrCreate([
            'user_id' => 1,
            'name' => 'category 3.2.2',
            'slug' => 'category_3_2_2',
            'parent_id' => 6,
        ]);
    }
}
