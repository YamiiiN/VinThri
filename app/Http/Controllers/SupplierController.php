<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $suppliers = Supplier::all();
        $suppliers = Supplier::paginate(5); 
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
        ]);
   
        $supplier = new Supplier;
        $supplier->first_name = $request->first_name;
        $supplier->last_name = $request->last_name;
        $supplier->address = $request->address;
   
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('supplierImages'), $imageName);
            $supplier->image = $imageName;
        } else {
            // Handle case where no image is uploaded
            // You can set a default image or leave it blank depending on your requirements
            // For example:
            $supplier->image = 'default_image.jpg';
        }
     
        $supplier->save();
    
        return redirect()->route('supplier.index')->with('success','Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    // public function edit(Supplier $supplier_id)
    // {
    //     $supplier = Supplier::find($supplier_id);
    //     return view('supplier.edit', compact('supplier'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
        ]);
    
        $supplier->first_name = $request->first_name;
        $supplier->last_name = $request->last_name;
        $supplier->address = $request->address;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('supplierImages'), $imageName);
    
            if ($supplier->image && file_exists(public_path('supplierImages/' . $supplier->image))) {
                unlink(public_path('supplierImages/' . $supplier->image));
            }
    
            $supplier->image = $imageName;
        }
    
        $supplier->save();
    
        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully');
    }
}
