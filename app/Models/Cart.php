<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg',
        'date',
        'userId',
        'foodId',
        'quantity',
        'price'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'foodId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'userId', 'id');
    }
}
