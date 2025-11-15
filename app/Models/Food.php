<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'stock',
        'status',
        'image',
        'ingredients',
        'sku',
        'remark'
    ];

    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'category_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'foodId', 'id');
    }
}
