<?php
namespace App\Models;

use App\Models\Currency;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'supplier_id',
        'currency_id',
        'qty',
        'total_price',
        'date',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
