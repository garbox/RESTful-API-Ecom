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
use App\Http\Middleware\CheckApiKey;

Route::resource('admin', AdminController::class)->middleware(CheckApiKey::class);
Route::post("token/update", [ApiTokenController::class, 'update'])->middleware(CheckApiKey::class);
Route::resource('token', ApiTokenController::class)->middleware(CheckApiKey::class);

Route::get("cart/session/{session_id}", [CartController::class, 'cartBySession'])->middleware(CheckApiKey::class);
Route::get("cart/user/{user_id}", [CartController::class, 'cartByUser'])->middleware(CheckApiKey::class);
Route::resource('cart', CartController::class)->middleware(CheckApiKey::class);

Route::get("order/user/{user_id}", [OrderController::class, 'orderByUser'])->middleware(CheckApiKey::class);
Route::resource('order', OrderController::class)->middleware(CheckApiKey::class);

Route::get("product/{productId}/productType", [ProductController::class, 'productTypes'])->middleware(CheckApiKey::class);
Route::get("product/featured", [ProductController::class, 'featured'])->middleware(CheckApiKey::class);
Route::get("product/available", [ProductController::class, 'available'])->middleware(CheckApiKey::class);
Route::resource('product', ProductController::class)->middleware(CheckApiKey::class);

Route::resource('photo', PhotoController::class)->middleware(CheckApiKey::class);

Route::resource('prodtype', ProductTypeController::class)->middleware(CheckApiKey::class);
Route::get("prodtype/{prodTypeId}/products", [ProductTypeController::class, 'products'])->middleware(CheckApiKey::class);
Route::resource('shipping', ShippingController::class)->middleware(CheckApiKey::class);

Route::get("user/{userId}/shipping", [UserController::class, 'getShippingInfo'])->middleware(CheckApiKey::class);
Route::get("user/{userId}/cart", [UserController::class, 'getCartInfo'])->middleware(CheckApiKey::class);
Route::get("user/{userId}/totalSale", [UserController::class, 'totalSales'])->middleware(CheckApiKey::class);
Route::get("user/{userId}/orders", [UserController::class, 'getOrders'])->middleware(CheckApiKey::class);
Route::resource('user', UserController::class)->middleware(CheckApiKey::class);

