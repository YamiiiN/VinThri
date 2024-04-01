<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'supplier_id';
    
    protected $fillable = [
        'first_name', 'last_name', 'image', 'address', 
    ];

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class, 'supplier_id');
    }
}
