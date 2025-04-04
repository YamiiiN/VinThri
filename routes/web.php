<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GraphController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\FeedbackController;

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
Route::get('/', [MainPageController::class, 'welcome'])->name('welcome');

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

    Route::get('/orderCustomer', [OrderController::class, 'viewOrders'])->name('orderCustomer.index');
    Route::get('/orderItems/{order_id}', [OrderItemController::class, 'index'])->name('orderItems.index');

    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::get('/product/search', [ProductController::class, 'searchProduct'])->name('product.search');
});

// Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/orderAdmin', [AdminController::class, 'indexOrders'])->name('orderAdmin.index');
    Route::put('/orderAdmin/{orderId}', [AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    // Route::get('/graphs', [GraphController::class, 'index'])->name('graph.index');
    Route::get('/graphs', [GraphController::class, 'index'])->name('graphs.index');
});

Route::prefix('product')->middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

Route::prefix('category')->middleware(['auth', 'user-access:admin'])->group(function (){
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

Route::prefix('supplier')->middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/edit/{supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/update/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/destroy/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});

Route::prefix('inventory')->middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/edit/{inventory}', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/update/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
});

//Add to cart
Route::prefix('cart')->middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/input/{productId}', [CartController::class, 'showAddToCartForm'])->name('cart.show_add_form');
    Route::post('/add', [CartController::class, 'create'])->name('cart.create');
    Route::post('/store', [CartController::class, 'store'])->name('cart.store');
    Route::get('/display', [CartController::class, 'display'])->name('cart.display');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/delete/{productId}', [CartController::class, 'deleteCartItem'])->name('cart.delete');
});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


//GRAPH
// Route::get('/graphs', [GraphController::class, 'index'])->name('graph.index');

//ACTIVATE || DEACTIVATE CUSTOMER ACCOUNT
Route::get('/admin/customers', [AdminController::class, 'manageCustomers'])->name('admin.customers');
    Route::post('/admin/customers/{id}/activate', [AdminController::class, 'activateCustomer'])->name('admin.activateCustomer');
