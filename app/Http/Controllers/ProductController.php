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
        $inventories = Inventory::all(); // Fetch inventories from the database
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
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow multiple images
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'price' => 'required|numeric',
            'date_supplied' => 'required|date',
            'stock' => 'required|numeric',
        ]);

        $product = new Product();
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->unit_price = $validatedData['unit_price'];
        $product->category_id = $validatedData['category_id'];
        $images = [];
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('productImages'), $imageName);
            $images[] = $imageName;
        }
        $product->images = implode(',', $images);

        $product->save();

        $productSupplier = new ProductSupplier();
        $productSupplier->date_supplied = $validatedData['date_supplied'];
        $productSupplier->price = $validatedData['price'];
        $productSupplier->product_id = $product->product_id;
        $productSupplier->supplier_id = $validatedData['supplier_id'];
        $productSupplier->save();

        $inventories = new Inventory();
        $inventories->stock = $validatedData['stock'];
        $inventories->product_id = $product->product_id;
        $inventories->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        $categories = Category::all();
        $suppliers = Supplier::all();
        $productSupplier = ProductSupplier::where('product_id', $product_id)->first();

        $images = explode(',', $product->images);

        return view('product.edit', compact('product', 'categories', 'suppliers', 'productSupplier', 'images'));
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

        // Check if new images are uploaded
        if ($request->hasFile('new_images')) {
            $images = [];
            foreach ($request->file('new_images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('productImages'), $imageName);
                $images[] = $imageName;
            }
            $product->images = implode(',', $images);
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
    }

    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')->get();
        $inventories = Inventory::all();
        return view('product.searchProduct', compact('products', 'query', 'inventories'));
    }

}