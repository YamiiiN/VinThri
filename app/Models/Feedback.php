<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'date', 'images', 'comment', 'order_item_id',
    ];

    public function order_item()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
}
