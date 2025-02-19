<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ApiTokenController;
use App\Http\Middleware\CheckApiKey;
use App\Http\Middleware\UserAccess;
use App\Http\Middleware\AdminAccess;

//Admin Routes
Route::middleware(['token_check', 'admin'])->group(function () {
    Route::get("admin/all", [AdminController::class, 'index']);
    Route::get("admin/", [AdminController::class, 'show']);
    Route::post("admin/", [AdminController::class, 'store']);
    Route::put("admin/", [AdminController::class, 'update']);
    Route::delete("admin/", [AdminController::class, 'destroy']);
    Route::get("admin/cart/all", [CartController::class, 'index']);
    Route::resource('token', ApiTokenController::class)->except(['create', 'edit']);
    Route::post("product/", [ProductController::class, 'store']);
    Route::put("product/{product_id}", [ProductController::class, 'update']);
    Route::delete("product/{product_id}", [ProductController::class, 'destory']);
    Route::delete("photo/{photo_id}", [PhotoController::class, 'destory']);
    Route::resource('category', CategoryController::class)->except(['create', 'edit', 'update']);
    Route::get("category/{categoryId}/products", [CategoryController::class, 'products']);
});

//User Routes
Route::middleware(['token_check', 'user'])->group(function () {
    Route::get("user/", [UserController::class, 'show']);
    Route::put("user/", [UserController::class, 'update']);
    Route::delete("user/", [UserController::class, 'destroy']);
    Route::get("user/shipping", [UserController::class, 'getShippingInfo']);
    Route::get("user/cart", [UserController::class, 'getCartInfo']);
    Route::get("user/totalSale", [UserController::class, 'totalSales']);
    Route::get("user/orders", [UserController::class, 'getOrders']);
    Route::get("cart/session/{session_id}", [CartController::class, 'cartBySession']);
    Route::get("cart/user/", [CartController::class, 'cartByUser']);
    Route::resource('cart', CartController::class)->except(['create', 'edit']);
    Route::get("order/user/", [OrderController::class, 'orderByUser']);
    Route::resource('order', OrderController::class)->except(['create', 'edit']);
    Route::resource('shipping', ShippingController::class)->except(['create', 'edit']);
});

//Global Routes
Route::middleware('token_check')->group(function () {
    Route::post("user/login", [UserController::class, 'login']);
    Route::post("admin/login", [AdminController::class, 'login']);
    Route::post("user/", [UserController::class, 'store']);
    Route::get("product/featured", [ProductController::class, 'featured']);
    Route::get("product/available", [ProductController::class, 'available']);
    Route::get("product/{productId}", [ProductController::class, 'available']);
    Route::get("product/search/{search}", [ProductController::class, 'search']);
    Route::resource('photo', PhotoController::class)->except(['create', 'edit', 'update', 'index']);
});










