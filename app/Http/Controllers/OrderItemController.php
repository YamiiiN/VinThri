<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index($order_id)
    {
        $customer = auth()->user()->customer;

        $orders = $customer->orders;
    
        $orderItems = OrderItem::where('order_id', $order_id)->get();
        
        return view('orderCustomer.indexItem', compact('orderItems', 'order_id'));
      
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
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
