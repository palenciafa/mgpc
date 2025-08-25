<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'supplier_id', 'stock', 'price'];

    // Define relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Similarly, if you have suppliers relationship:
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}


