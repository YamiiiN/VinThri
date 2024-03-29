<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Order;

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

    // public function updateOrderStatus(Order $order, $status)
    // {
    //     $order->update(['status' => $status]);
    //     return redirect()->back()->with('success', 'Order status updated successfully.');
    // }

    public function updateOrderStatus($orderId, Request $request)
    {
        $status = $request->input('status');
    
        // Find the order by its ID
        $order = Order::findOrFail($orderId);
    
        // Update the order status
        $order->update(['status' => $status]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
    
    public function indexOrders()
    {
        $orders = Order::with('customer')->get();
        // dd($orders);
        return view('orderAdmin.index', compact('orders'));
    }

}
