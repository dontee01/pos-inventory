<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Pending_orderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FilterController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    var_dump('testing...');exit;
    return view('welcome');
});


Route::any('/home', function () {
    return view('home');
})->middleware('login');

Route::get('/', [UserController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);


// // items
Route::get('/items', [ItemController::class, 'index'])->middleware('login');
Route::group(['prefix' => 'item', 'middleware' => 'login'], function() {
    Route::get('/add', [ItemController::class, 'show_add']);
    Route::post('/add', [ItemController::class, 'add']);
    Route::get('/edit/{id}', [ItemController::class, 'show_edit']);
    Route::post('/edit/{id}', [ItemController::class, 'edit']);
    Route::post('/delete/{id}', [ItemController::class, 'delete']);
});

// // customers
Route::get('/customers', [CustomerController::class, 'index'])->middleware('login');
Route::group(['prefix' => 'customer', 'middleware' => 'login'], function() {
    Route::get('/add', [CustomerController::class, 'show_add']);
    Route::post('/add', [CustomerController::class, 'add']);
    Route::get('/edit/{id}', [CustomerController::class, 'show_edit']);
    Route::post('/edit/{id}', [CustomerController::class, 'edit']);
    Route::post('/delete/{id}', [CustomerController::class, 'delete']);
});

// suppliers
Route::get('/suppliers', [SupplierController::class, 'index'])->middleware('login');
Route::group(['prefix' => 'supplier', 'middleware' => 'login'], function() {
    Route::get('/', [SupplierController::class, 'index']);
    Route::get('/add', [SupplierController::class, 'show_add']);
    Route::post('/add', [SupplierController::class, 'add']);
    Route::get('/edit/{id}', [SupplierController::class, 'show_edit']);
    Route::post('/edit/{id}', [SupplierController::class, 'edit']);
    Route::post('/delete/{id}', [SupplierController::class, 'delete']);
});

// drivers
Route::get('/drivers', [DriverController::class, 'index'])->middleware('login');
Route::group(['prefix' => 'driver', 'middleware' => 'login'], function() {
    Route::get('/add', [DriverController::class, 'show_add']);
    Route::post('/add', [DriverController::class, 'add']);
    Route::get('/edit/{id}', [DriverController::class, 'show_edit']);
    Route::post('/edit/{id}', [DriverController::class, 'edit']);
    Route::post('/delete/{id}', [DriverController::class, 'delete']);
});

// users
Route::get('/users', [StaffController::class, 'index'])->middleware('login');
Route::group(['prefix' => 'user', 'middleware' => 'login'], function() {
    Route::get('/add', [StaffController::class, 'show_add']);
    Route::post('/add', [StaffController::class, 'add']);
    Route::get('/edit/{id}', [StaffController::class, 'show_edit']);
    Route::post('/edit/{id}', [StaffController::class, 'edit']);
    Route::post('/delete/{id}', [StaffController::class, 'delete']);
});

Route::group(['prefix' => 'order', 'middleware' => 'login'], function() {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'populate']);
});

Route::group(['prefix' => 'cart', 'middleware' => 'login'], function() {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::get('/checkout/{id}', [CartController::class, 'show_checkout']);
    Route::post('/checkout', [CartController::class, 'checkout']);
    Route::post('/delete/{id}', [CartController::class, 'delete']);
});

Route::group(['prefix' => 'pending', 'middleware' => 'login'], function() {
    Route::get('/', [Pending_orderController::class, 'index']);
    Route::get('/{id}', [Pending_orderController::class, 'show_order']);
    Route::post('/checkout/{id}', [Pending_orderController::class, 'checkout']);
});

Route::group(['prefix' => 'sales', 'middleware' => 'login'], function() {
    Route::get('/', [SalesController::class, 'index']);
    Route::get('/transaction/{transaction_ref}', [SalesController::class, 'show_order']);
    Route::post('/checkout/{transaction_ref}', [SalesController::class, 'checkout']);
    Route::get('/individual', [SalesController::class, 'individual']);
    Route::get('/individual/{id}', [SalesController::class, 'populate']);
    Route::post('/cart/add', [SalesController::class, 'cart_add']);
    Route::get('/cart', [SalesController::class, 'cart_show']);
    Route::post('/cart/delete/{id}', [SalesController::class, 'cart_delete']);
    Route::post('/cart/checkout', [SalesController::class, 'cart_checkout']);
    Route::get('/bottle', [SalesController::class, 'bottle_show']);
    Route::post('/bottle/add', [SalesController::class, 'bottle_add']);
    Route::get('/test', [SalesController::class, 'test']);

    Route::get('/receipt/{transaction_ref}', [SalesController::class, 'receipt']);
});

Route::group(['prefix' => 'purchase', 'middleware' => 'login'], function() {
    Route::get('/', [PurchaseController::class, 'index']);
    Route::get('/show/{id}', [PurchaseController::class, 'populate']);
    Route::get('/cart', [PurchaseController::class, 'cart_show']);
    Route::post('/cart/add', [PurchaseController::class, 'cart_add']);
    Route::post('/cart/checkout', [PurchaseController::class, 'cart_checkout']);
    Route::get('/bottle', [PurchaseController::class, 'bottle_show']);
    Route::post('/bottle/add', [PurchaseController::class, 'bottle_add']);
    // Route::get('/transaction/{transaction_ref}', [PurchaseController::class, 'show_order']);
    Route::post('/cart/delete/{id}', [PurchaseController::class, 'cart_delete']);
});

Route::group(['prefix' => 'bottle', 'middleware' => 'login'], function() {
    Route::get('/show', [BottleController::class, 'bottle_show']);
    Route::post('/log', [BottleController::class, 'bottle_log']);
});

Route::group(['prefix' => 'report', 'middleware' => 'login'], function() {
    Route::get('/', [ReportController::class, 'index']);
    Route::post('/show', [ReportController::class, 'report']);
});

Route::group(['prefix' => 'filter', 'middleware' => 'login'], function() {
    Route::get('/', [FilterController::class, 'index']);
    Route::post('/show', [FilterController::class, 'report']);
});

Route::get('/print', function () {
    return view('print-store');
});