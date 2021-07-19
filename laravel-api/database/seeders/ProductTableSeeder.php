<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new Product();
        $product->user_id = 1;
        $product->name = 'Product name 1';
        $product->slug = 'product_name_1';
        $product->image = null;
        $product->status = true;
        $product->total_stock = 20;
        $product->price = 400;
        $product->description = 'This is product description 1.';
        $product->save();
        $product->productCategory()->attach(1);
        $product->productCategory()->attach(2);
        $product->productCategory()->attach(3);


        $product = new Product();
        $product->user_id = 1;
        $product->name = 'Product name 2';
        $product->slug = 'product_name_2';
        $product->image = null;
        $product->status = false;
        $product->total_stock = 50;
        $product->price = 30;
        $product->description = 'This is product description 2.';
        $product->save();
        $product->productCategory()->attach(2);


        $product = new Product();
        $product->user_id = 1;
        $product->name = 'Product name 3';
        $product->slug = 'product_name_3';
        $product->image = null;
        $product->status = true;
        $product->total_stock = 0;
        $product->price = 500;
        $product->description = 'This is product description 3.';
        $product->save();
        $product->productCategory()->attach(1);


        $product = new Product();
        $product->user_id = 1;
        $product->name = 'Product name 4';
        $product->slug = 'product_name_4';
        $product->image = null;
        $product->status = false;
        $product->total_stock = 6;
        $product->price = 500;
        $product->description = 'This is product description 4.';
        $product->save();
        $product->productCategory()->attach(3);
        $product->productCategory()->attach(1);


        $product = new Product();
        $product->user_id = 1;
        $product->name = 'Product name 5';
        $product->slug = 'product_name_5';
        $product->image = null;
        $product->status = true;
        $product->total_stock = 40;
        $product->price = 50;
        $product->description = 'This is product description 5.';
        $product->save();
        $product->productCategory()->attach(3);
        $product->productCategory()->attach(2);

    }
}
