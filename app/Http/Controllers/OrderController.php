<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

// use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewOrders()
    {
        $user = auth()->user();

        if ($user) {
            $customer = $user->customer;

            if ($customer) {
                $orders = $customer->orders()->latest()->get();

                return view('orderCustomer.index', ['orders' => $orders]);
            } else {
                return redirect()->route('login')->with('error', 'Customer not found.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to view orders.');
        }
    }

    public function index()
    {
        //
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
