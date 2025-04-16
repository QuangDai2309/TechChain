<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Xiaomi Mi Band 5',
                'description' => 'The latest Apple Watch with advanced health features.',
                'price' => 19900,
                'image' => 'product-1.jpg',
                'stock' => 50,
                'category_id' => 1,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable Bluetooth speaker with deep, loud sound.',
                'price' => 27500,
                'image' => 'product-2.jpg',
                'stock' => 30,
                'category_id' => 2,
            ],
            [
                'name' => 'WiFi Security Camera',
                'description' => 'Full-frame mirrorless camera with high resolution.',
                'price' => 389999,
                'image' => 'product-3.jpg',
                'stock' => 20,
                'category_id' => 3,
            ],
            [
                'name' => 'Samsung Galaxy S21',
                'description' => 'Latest Samsung smartphone with advanced features.',
                'price' => 700,
                'image' => 'product-4.jpg',
                'stock' => 100,
                'category_id' => 4,
            ],
            [
                'name' => 'Sony WH-1000XM4',
                'description' => 'Noise-canceling over-ear headphones with superior sound quality.',
                'price' => 349.99,
                'image' => 'product-5.jpg',
                'stock' => 75,
                'category_id' => 5,
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'High-performance laptop with a sleek design.',
                'price' => 999.99,
                'image' => 'product-6.jpg',
                'stock' => 40,
                'category_id' => 6,
            ],
            [
                'name' => 'Apple iPhone 13',
                'description' => 'Latest iPhone with advanced camera and performance.',
                'price' => 799.99,
                'image' => 'product-7.jpg',
                'stock' => 60,
                'category_id' => 4,
            ],
            [
                'name' => 'Bose SoundLink',
                'description' => 'Portable Bluetooth speaker with deep, loud sound.',
                'price' => 199.99,
                'image' => 'product-8.jpg',
                'stock' => 50,
                'category_id' => 2,
            ],
        ]);
    }
}
