<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'image',
        'address',
        'email',
        'password',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activateCustomer($id)
{
    // Find the customer by ID
    $customer = Customer::findOrFail($id);

    // Toggle the status
    $customer->status = ($customer->status == 'active') ? 'deaactived' : 'active';

    // Save the changes
    $customer->save();

    // Redirect back to the customer management page
    return redirect()->route('customers')->with('success', 'Customer status updated successfully.');
}
}
