<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'user_id',
        'title',
        'description',
        'amount',
        'expense_date',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ExpenseSubcategory::class, 'subcategory_id');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
