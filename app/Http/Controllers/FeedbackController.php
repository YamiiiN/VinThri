<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\OrderItem;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $orderItemId = $request->query('order_item_id');
        return view('feedback.create', compact('orderItemId'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $customer = auth()->user()->customer;
     
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }
     
        $validatedData = $request->validate([
            'order_item_id' => 'required|exists:order_items,order_item_id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'comment' => 'required|string',
        ]);
     
        $orderItem = OrderItem::findOrFail($validatedData['order_item_id']);
         
        $order = $orderItem->order;
     
        if ($order->customer_id !== $customer->customer_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
     
        $feedback = new Feedback();
        $feedback->order_item_id = $validatedData['order_item_id'];
        $feedback->customer_id = $order->customer_id; // Use the customer ID from the order
        $feedback->comment = $validatedData['comment'];
        $feedback->date = now();
        $images = [];
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('feedbackImages'), $imageName);
            $images[] = $imageName;
        }
        $feedback->images = implode(',', $images);

        $feedback->save();
     
        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
