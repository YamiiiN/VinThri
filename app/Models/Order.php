<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dompdf\Dompdf;
use Dompdf\Options;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'date', 'status', 'customer_id',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function generateReceiptPdf()
    {
        // Generate PDF content here, for example:
        $htmlContent= '<h1>Order Receipt No. ' . $this->order_id . '</h1>';
        $htmlContent .= '<p>Order Date: ' . $this->date . '</p>';

        return $htmlContent;
    }
}
