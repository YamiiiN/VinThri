<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';
    
    protected $fillable = [
        'first_name', 'last_name', 'image', 'address', 'email', 'password', 'user_id',
    ];

    public function cart()
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'customer_id');
    }
}
