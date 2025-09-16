<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::insert([
            ['code' => 'IDR', 'name' => 'Rupiah'],
            ['code' => 'USD', 'name' => 'Dolar US'],
            ['code' => 'YEN', 'name' => 'Yen'],
            ['code' => 'EUR', 'name' => 'Euro'],
            ['code' => 'SGD', 'name' => 'Dolar Singapura'],
        ]);
    }
}
