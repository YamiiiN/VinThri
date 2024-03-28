<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\ProductSupplier;
use App\Models\Inventory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $productSuppliers = ProductSupplier::all();
        $products = Product::latest()->paginate(5);
        return view('product.index', compact('productSuppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $inventories = Inventory::all();
        return view('product.create', compact('categories', 'suppliers', 'inventories')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'unit_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,category_id',
            'images.*' => 'required|image|max:2048',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'price' => 'required|numeric',
            'date_supplied' => 'required|date',
            'stock' => 'required|numeric',
        ]);
        $imagePaths = [];
        foreach ($request->file('images') as $image) {
            $imageName = basename($image->getClientOriginalName());

            if (!file_exists(public_path('imgs') . '/' . $imageName)) {
                $image->move(public_path('imgs'), $imageName);
            }

            $imagePaths[] = 'imgs/' . $imageName;
        }

        $product = new Product();
        $product->name = $validatedData['name'];
        $product->image = implode(',', $imagePaths);
        $product->description = $validatedData['description'];
        $product->unit_price = $validatedData['unit_price'];
        $product->category_id = $validatedData['category_id'];

        $product->save();

        $productSupplier = new ProductSupplier();
        $productSupplier->date_supplied = $validatedData['date_supplied'];
        $productSupplier->price = $validatedData['price'];
        $productSupplier->product_id = $product->product_id; // Correctly referencing the primary key column
        $productSupplier->supplier_id = $validatedData['supplier_id'];
        $productSupplier->save();

        $inventories = new Inventory();
        $inventories->stock = $validatedData['stock'];
        $inventories->product_id = $product->product_id; // Correctly referencing the primary key column
        $inventories->save();

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
     */ public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        $categories = Category::all();
        $suppliers = Supplier::all();
        $productSupplier = ProductSupplier::where('product_id', $product_id)->first();
        return view('product.edit', compact('product', 'categories', 'suppliers', 'productSupplier'));
        // $product = Product::find($product_id);
        // $categories = Category::all(); 
        // $suppliers = Supplier::all(); 
        // $productSuppliers = ProductSupplier::all($product->$product_id );

        // return view('product.edit', compact('product', 'categories', 'suppliers', 'productSuppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'images.*' => 'required|image|max:2048',
            'description' => 'required',
            'unit_price' => 'required',
            'category_id' => 'required'
        ]);

        $imagePaths = [];

        foreach ($request->file('images') as $image) {
            $imageName = basename($image->getClientOriginalName());

            if (!file_exists(public_path('imgs') . '/' . $imageName)) {
                $image->move(public_path('imgs'), $imageName);
            }

            $imagePaths[] = 'imgs/' . $imageName;
        }


        $product->name = $request->name;
        $product->image = implode(',', $imagePaths);
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
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
    }
}
