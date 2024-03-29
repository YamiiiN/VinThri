<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;


use Illuminate\Http\Request;


class CartController extends Controller
{
    public function deleteCartItem($productId)
    {
        try {
            // Find the cart item by product ID and delete it
            $cartItem = Cart::where('product_id', $productId)->first();

            if (!$cartItem) {
                return response()->json(['message' => 'Cart item not found'], 404);
            }

            $cartItem->delete();

            return response()->json(['message' => 'Cart item deleted successfully'], 200);
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json(['message' => 'Failed to delete cart item'], 500);
        }
    }



   public function checkout(Request $request)
{
    // Retrieve the current logged-in customer's ID
    $customerId = auth()->user()->customer->customer_id;

    // Create a new order
    $order = new Order();
    $order->date = now(); // Current date
    $order->status = 'pending'; // Default status
    $order->customer_id = $customerId;
    $order->save();

    // Retrieve the newly created order ID
    $orderId = $order->order_id; // Assuming 'order_id' is the primary key

    // Retrieve cart items from the request
    $cartItems = $request->input('cartItems');

    // Create order items for each cart item
    foreach ($cartItems as $cartItem) {
        $orderItem = new OrderItem();
        $orderItem->quantity = $cartItem['quantity'];
        $orderItem->order_id = $orderId;
        $orderItem->product_id = $cartItem['product_id'];
        $orderItem->save();

        // Deduct quantity from inventory stock
        $inventory = Inventory::where('product_id', $cartItem['product_id'])->first();
        if ($inventory) {
            $inventory->stock -= $cartItem['quantity'];
            $inventory->save();
        } else {
            // Handle case where inventory record doesn't exist for the product
        }
    }
    Cart::whereIn('product_id', collect($cartItems)->pluck('product_id'))->delete();
    // Optionally, update inventory or perform any other necessary actions

    // Return a response indicating success
    return response()->json(['message' => 'Checkout successful'], 200);
}

public function display(Request $request)
{
    // Retrieve the customer ID from the authenticated user
    $customerId = auth()->user()->customer->customer_id;

    // Fetch the cart items for the current customer
    $cartItems = Cart::where('customer_id', $customerId)->get();

    // You may want to fetch additional information about the products in the cart, like their names, prices, etc.
    // You can do this by joining the Cart table with the Inventory table or directly querying the Inventory table

    // For example, assuming you have a 'products' table and each cart item has a 'product_id' referencing a product:
 // Fetch cart items with product information
$cartItemsWithProductInfo = Cart::where('customer_id', $customerId)
->join('products', 'carts.product_id', '=', 'products.product_id')
->select('carts.*', 'products.name', 'products.unit_price')
->get();



    // Pass the cart items to the view
    return view('cart.display_items', ['cartItems' => $cartItemsWithProductInfo]);
}

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
        return redirect('/cart/display')->with('success', 'Product added to cart successfully.');
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


//hi
