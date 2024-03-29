<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;

use Illuminate\Http\Request;


class CartController extends Controller
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
        $productId = $request->input('product_id');
        $customerId = auth()->user()->customer->id; // Assuming you have authentication and a customer relationship

        // Check if the product already exists in the cart for the current customer
        $existingCartItem = Cart::where('customer_id', $customerId)
                                 ->where('product_id', $productId)
                                 ->first();

        if ($existingCartItem) {
            // Update the quantity of the existing product in the cart
            $existingCartItem->increment('quantity');
        } else {
            // Add the product to the cart with a quantity of 1
            $cartItem = new Cart();
            $cartItem->customer_id = $customerId;
            $cartItem->product_id = $productId;
            $cartItem->quantity = 1;
            $cartItem->save();
        }

        // Optionally, provide feedback to the user
        return view('cart.input')->with('success', 'Product added to cart successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'customer_id' => 'required|numeric',
        ]);

        // Create a new Cart instance and fill it with validated data
        $cart = new Cart();
        $cart->product_id = $validatedData['product_id'];
        $cart->quantity = $validatedData['quantity'];
        $cart->customer_id = $validatedData['customer_id'];

        // Save the cart instance to the database
        $cart->save();

        // Redirect to the home page with a success message
        return redirect('/home')->with('success', 'Product added to cart successfully.');
    }

    public function showAddToCartForm($productId)
    {
        // Pass the product ID to the view
        $customerId = auth()->user()->customer->customer_id;
        return view('cart.input', ['productId' => $productId, 'customerId' => $customerId]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
