<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ApiTokenController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('admin', AdminController::class);
Route::resource('token', ApiTokenController::class);

Route::get("cart/session/{session_id}", [CartController::class, 'cartBySession']);
Route::get("cart/user/{user_id}", [CartController::class, 'cartByUser']);
Route::resource('cart', CartController::class);

Route::get("order/user/{user_id}", [OrderController::class, 'orderByUser']);
Route::resource('order', OrderController::class);

Route::get("product/{productId}/productType", [ProductController::class, 'productTypes']);
Route::get("product/featured", [ProductController::class, 'featured']);
Route::get("product/available", [ProductController::class, 'available']);
Route::resource('product', ProductController::class);

Route::resource('photo', PhotoController::class);

Route::resource('prodtype', ProductTypeController::class);
Route::get("prodtype/{prodTypeId}/products", [ProductTypeController::class, 'products']);
Route::resource('shipping', ShippingController::class);

Route::get("user/{userId}/orders", [UserController::class, 'getOrders']);
Route::get("user/{userId}/shipping", [UserController::class, 'getShippingInfo']);
Route::get("user/{userId}/cart", [UserController::class, 'getCartInfo']);
Route::get("user/{userId}/totalSale", [UserController::class, 'totalSales']);
Route::resource('user', UserController::class);
