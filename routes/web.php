<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
    
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save'); 
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::get('/profile', [UserController::class, 'userprofile'])->name('profile');
});

//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');
 
    // Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin/profile');
 
    // Route::get('/admin/products', [ProductController::class, 'index'])->name('admin/products');
    // Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin/products/create');
    // Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin/products/store');
    // Route::get('/admin/products/show/{id}', [ProductController::class, 'show'])->name('admin/products/show');
    // Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin/products/edit');
    // Route::put('/admin/products/edit/{id}', [ProductController::class, 'update'])->name('admin/products/update');
    // Route::delete('/admin/products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin/products/destroy');

    // Route::prefix('admin/products')->group(function () {
    //     Route::get('/', [ProductController::class, 'index'])->name('admin/products');
    //     Route::get('/create', [ProductController::class, 'create'])->name('admin/products/create');
    //     Route::post('/store', [ProductController::class, 'store'])->name('admin/products/store');
    //     // Route::get('/show/{id}', [ProductController::class, 'show'])->name('admin/products/show');
    //     Route::get('/edit/{product_id}', [ProductController::class, 'edit'])->name('admin/products/edit');
    //     Route::put('/update/{product_id}', [ProductController::class, 'update'])->name('admin/products/update');
    //     Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('admin/products/destroy');
    // });

    // Route::prefix('product')->group(function () {
    //     Route::get('/', [ProductController::class, 'index'])->name('product.index');
    //     Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    //     Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    //     Route::get('/edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit');
    //     Route::put('/update/{product}', [ProductController::class, 'update'])->name('product.update');
    //     Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    // });
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

Route::prefix('supplier')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/edit/{supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/update/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/destroy/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    // Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    // Route::get('/edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit');
    // Route::put('/update/{product}', [ProductController::class, 'update'])->name('product.update');
    // Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});


Route::prefix('inventory')->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    // Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
    // Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/edit/{inventory}', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/update/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    // Route::delete('/destroy/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});