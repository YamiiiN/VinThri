<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Inventory;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $products = Product::all();
        $inventories = Inventory::all();

        return view('home', compact('inventories'));
        // return view('home');
    }
    public function welcome()
    {
        $products = Product::all();
        $inventories = Inventory::all();

        return view('welcome', compact('inventories'));
        // return view('home');
    }
    public function adminHome()
    {
        return view('dashboard');
    }
}

//hi
?>

