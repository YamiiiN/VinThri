<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $products = Product::latest()->paginate(5); 
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); 
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'unit_price' => 'required',
            'category_id' => 'required',
        ]);
   
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->category_id = $request->category_id;
   
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('productImages'), $imageName);
            $product->image = $imageName;
        } else {
            // Handle case where no image is uploaded
            // You can set a default image or leave it blank depending on your requirements
            // For example:
            $product->image = 'default_image.jpg';
        }
     
        $product->save();
    
        return redirect()->route('product.index')->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // return view('product.show', compact('product'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product_id)
    {
        $product = Product::find($product_id);
        $categories = Category::all(); 

        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'unit_price' => 'required',
            'category_id' => 'required'
        ]);
    
        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->category_id = $request->category_id;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('productImages'), $imageName);
    
            if ($product->image && file_exists(public_path('productImages/' . $product->image))) {
                unlink(public_path('productImages/' . $product->image));
            }
    
            $product->image = $imageName;
        }
    
        $product->save();
    
        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
        // Product::destroy($product_id);
        // return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
