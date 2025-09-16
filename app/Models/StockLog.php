<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'user_id',
        'supplier_id',
        'buying_price',
        'total_price', // Added to allow storing total price for OUT logs
        'sale_id', // Add this line
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function sale()
{
    return $this->belongsTo(Sale::class);
}


}
