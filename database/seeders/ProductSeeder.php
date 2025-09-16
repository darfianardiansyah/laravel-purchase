<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            ['code' => 'HDD', 'name' => 'Harddisk'],
            ['code' => 'KYBD', 'name' => 'Keyboard'],
            ['code' => 'MNTR', 'name' => 'Monitor'],
            ['code' => 'PRCS', 'name' => 'Prosesor'],
            ['code' => 'PWSP', 'name' => 'Power Supply'],
            ['code' => 'RAM', 'name' => 'RAM'],
        ]);
    }
}
