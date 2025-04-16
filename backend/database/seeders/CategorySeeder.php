<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Watches',
                'description' => 'Devices and gadgets',
            ],
            [
                'name' => 'Speaker',
                'description' => 'Printed and digital books',
            ],
            [
                'name' => 'Camera',
                'description' => 'Apparel and accessories',
            ],
            [
                'name' => 'Phones',
                'description' => 'Apparel and accessories',
            ],
            [
                'name' => 'Headphones',
                'description' => 'Apparel and accessories',
            ],
            [
                'name' => 'Laptop',
                'description' => 'Apparel and accessories',
            ],
        ]);
    }
}
