<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Inventory;

class MainPageController extends Controller
{
    public function welcome()
    {
        $products = Product::all();
        $inventories = Inventory::all();

        return view('home', compact('inventories'));
        // return view('home');
    }
}
