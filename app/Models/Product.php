<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'supplier_id',
        'stock',
        'price',
    ];

    // 🔹 Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // 🔹 Helper method for adding stock
    public function addStock($quantity, $userId = null)
    {
        $this->increment('stock', $quantity);

        StockLog::create([
            'product_id' => $this->id,
            'type'       => 'in',
            'quantity'   => $quantity,
            'user_id'    => $userId,
        ]);
    }
}
