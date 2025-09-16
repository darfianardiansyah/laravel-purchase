<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Currency;
use App\Models\Product;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::pluck('id','name');
        $currencies = Currency::pluck('id','code');
        $products = Product::pluck('id','name');

        Purchase::insert([
            [
                'date' => '2025-01-01',
                'supplier_id' => $suppliers['PT ABC'],
                'currency_id' => $currencies['USD'],
                'product_id' => $products['Keyboard'],
                'qty' => 2,
                'total_price' => 20.00,
            ],
            [
                'date' => '2025-01-02',
                'supplier_id' => $suppliers['PT Elektrindo'],
                'currency_id' => $currencies['USD'],
                'product_id' => $products['RAM'],
                'qty' => 3,
                'total_price' => 50.00,
            ],
            [
                'date' => '2025-01-20',
                'supplier_id' => $suppliers['PT ABC'],
                'currency_id' => $currencies['USD'],
                'product_id' => $products['Prosesor'],
                'qty' => 2,
                'total_price' => 11.00,
            ],
            [
                'date' => '2025-01-02',
                'supplier_id' => $suppliers['PT Elektrindo'],
                'currency_id' => $currencies['USD'],
                'product_id' => $products['Harddisk'],
                'qty' => 3,
                'total_price' => 25.00,
            ],
            [
                'date' => '2025-01-20',
                'supplier_id' => $suppliers['PT ABC'],
                'currency_id' => $currencies['SGD'],
                'product_id' => $products['Prosesor'],
                'qty' => 2,
                'total_price' => 15.00,
            ],
            [
                'date' => '2025-01-02',
                'supplier_id' => $suppliers['PT Elektrindo'],
                'currency_id' => $currencies['SGD'],
                'product_id' => $products['Harddisk'],
                'qty' => 3,
                'total_price' => 30.00,
            ],
            [
                'date' => '2025-01-01',
                'supplier_id' => $suppliers['PT ABC'],
                'currency_id' => $currencies['SGD'],
                'product_id' => $products['Power Supply'],
                'qty' => 2,
                'total_price' => 3.00,
            ],
            [
                'date' => '2025-01-02',
                'supplier_id' => $suppliers['PT Elektrindo'],
                'currency_id' => $currencies['SGD'],
                'product_id' => $products['Monitor'],
                'qty' => 3,
                'total_price' => 17.00,
            ],
            [
                'date' => '2025-02-19',
                'supplier_id' => $suppliers['PT Batavia Mandiri'],
                'currency_id' => $currencies['YEN'],
                'product_id' => $products['Power Supply'],
                'qty' => 30,
                'total_price' => 250.00,
            ],
            [
                'date' => '2025-03-28',
                'supplier_id' => $suppliers['PT Elektronik Jaya'],
                'currency_id' => $currencies['EUR'],
                'product_id' => $products['Prosesor'],
                'qty' => 35,
                'total_price' => 650.00,
            ],
            [
                'date' => '2025-02-19',
                'supplier_id' => $suppliers['PT Komputindo Nusantara'],
                'currency_id' => $currencies['USD'],
                'product_id' => $products['Monitor'],
                'qty' => 35,
                'total_price' => 1250.00,
            ],
            [
                'date' => '2025-05-18',
                'supplier_id' => $suppliers['PT Elektronik Jaya'],
                'currency_id' => $currencies['EUR'],
                'product_id' => $products['RAM'],
                'qty' => 590,
                'total_price' => 3720.00,
            ],
        ]);
    }
}
