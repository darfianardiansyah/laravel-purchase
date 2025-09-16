<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usd = Currency::where('code', 'USD')->first()->id;
        $sgd = Currency::where('code', 'SGD')->first()->id;

        ExchangeRate::insert([
            ['currency_id' => $usd, 'date' => '2025-01-01', 'rate' => 12000.00],
            ['currency_id' => $usd, 'date' => '2025-01-20', 'rate' => 12500.00],
            ['currency_id' => $usd, 'date' => '2025-02-06', 'rate' => 12100.00],
            ['currency_id' => $usd, 'date' => '2025-03-25', 'rate' => 15000.00],

            ['currency_id' => $sgd, 'date' => '2025-01-01', 'rate' => 10000.00],
            ['currency_id' => $sgd, 'date' => '2025-01-02', 'rate' => 10100.00],
        ]);
    }
}
