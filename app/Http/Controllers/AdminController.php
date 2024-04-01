<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Customer;

use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Notifications\OrderPlacedNotification;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $admins = Admin::latest()->paginate(5);
        return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function updateOrderStatus($orderId, Request $request)
    {
        $status = $request->input('status');

        // Find the order by its ID
        $order = Order::findOrFail($orderId);

        // Update the order status
        $order->update(['status' => $status]);

        // Send notification with PDF receipt only when the order is changed to 'delivered'
        if ($status === 'delivered') {
            $user = auth()->user();
            $user->notify(new OrderPlacedNotification($order->generateReceiptPdf()));
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    // public function updateOrderStatus($orderId, Request $request)
    // {
    //     $status = $request->input('status');

    //     // Find the order by its ID
    //     $order = Order::findOrFail($orderId);

    //     // Update the order status
    //     $order->update(['status' => $status]);

    //             // Send notification with PDF receipt only when the order is delivered
    //             if ($order->status === 'delivered') {
    //                 $user = auth()->user();
    //                 $user->notify(new OrderPlacedNotification($order->generateReceiptPdf()));
    //             }

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Order status updated successfully.');
    // }

    public function indexOrders()
    {
        $orders = Order::with('customer')->get();
        // dd($orders);
        return view('orderAdmin.index', compact('orders'));
    }

    public function manageCustomers()
{
    // Fetch all customers
    $customers = Customer::all();

    // Pass the customers data to the view
    return view('customers', compact('customers'));
}

public function activateCustomer($id)
{
    // Find the customer by ID
    $customer = Customer::findOrFail($id);

    // Toggle the status
    $customer->status = ($customer->status == 'active') ? 'deactivated' : 'active';

    // Save the changes
    $customer->save();
    $user = User::find($customer->user_id);

    // Update the status of the user
    if ($user) {
        $user->status = $customer->status; // Assuming user status mirrors customer status
        $user->save();

    // Redirect back to the customer management page
    return redirect()->route('admin.customers')->with('success', 'Customer status updated successfully.');
}

}
}
