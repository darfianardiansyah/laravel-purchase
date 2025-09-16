<?php
namespace App\Models;

use App\Models\Product;
use App\Models\Currency;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function supplier()
    {return $this->belongsTo(Supplier::class);}
    public function currency()
    {return $this->belongsTo(Currency::class);}
    public function product()
    {return $this->belongsTo(Product::class);}
}
