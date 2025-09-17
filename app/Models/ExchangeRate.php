<?php

namespace App\Models;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'date',
        'rate',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'rate' => 'decimal:2',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
