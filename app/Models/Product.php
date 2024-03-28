<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'name', 'description', 'unit_price', 'category_id', 'image',
    ];

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }
}
