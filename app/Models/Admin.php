<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'facebook_id',
        'google_id',
        'github_id',
        'password',
        'photo',
        'phone',
        'address',
        'dob',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'userId', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function duecollection()
    {
        return $this->hasMany(DueCollection::class, 'user_id');
    }
}
