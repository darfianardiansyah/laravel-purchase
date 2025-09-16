<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::insert([
            ['name' => 'PT ABC', 'address' => 'Jl Pahlawan Surabaya'],
            ['name' => 'PT Elektrindo', 'address' => 'JL A Yani Jakarta'],
            ['name' => 'PT Pelangi', 'address' => 'Jl Nias Bogor'],
            ['name' => 'PT Komputindo Nusantara', 'address' => 'Jl Bali Jakarta'],
            ['name' => 'PT Batavia Mandiri', 'address' => 'Jl Wilis Bandung'],
            ['name' => 'PT Elektronik Jaya', 'address' => 'Jl Semeru Jakarta'],
        ]);
    }
}
