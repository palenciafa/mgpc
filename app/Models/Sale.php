<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StockLog;

class Sale extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'total_price',
        'user_id',
        'customer_name',
    ];

    // 🔹 Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
