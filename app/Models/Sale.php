<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['product_id', 'quantity', 'total_price','user_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
{
    return $this->belongsTo(Category::class);
}

}
