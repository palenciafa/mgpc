<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'control_number',
        'brand',        
        'name',
        'date_issued',
        'employee_id',
        'status',
    ];

    protected $casts = [
        'date_issued' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
