<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ApiTokenController;

//Admin Routes
Route::middleware(['token_check', 'admin'])->group(function () {
    Route::get("admin/all", [AdminController::class, 'index'])->name('admin.all');
    Route::get("admin/{admin_id}", [AdminController::class, 'show'])->name('admin.get');
    Route::get("admin/current", [AdminController::class, 'currentAdmin'])->name('admin.get.current');
    Route::post("admin/", [AdminController::class, 'store'])->name('admin.create');
    Route::patch("admin/", [AdminController::class, 'update'])->name('admin.update');
    Route::delete("admin/{admin_id}", [AdminController::class, 'destroy'])->name('admin.destroy');
    
    Route::get("cart/all", [CartController::class, 'index'])->name('cart.all');
    Route::get("cart/get/{cart}", [CartController::class, 'index'])->name('cart.get');
    
    Route::resource('category', CategoryController::class)->except(['create', 'edit']);
    Route::get("category/{category_id}/products", [CategoryController::class, 'products'])->name('category.products');

    Route::get("order/all", [OrderController::class, 'index'])->name('order.all');
    Route::get("order/{order_id}", [OrderController::class, 'show'])->name('admin.orders.show');
    Route::delete("order/{order_id}", [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get("order/user/{user_id}", [OrderController::class, 'orderByUser'])->name('order.user');
    Route::put("order/{order_id}", [OrderController::class, 'update'])->name('order.update');

    Route::post("product/", [ProductController::class, 'store'])->name('product.create');
    Route::put("product/{product_id}", [ProductController::class, 'update'])->name('product.update');
    Route::delete("product/{product_id}", [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get("product", [ProductController::class, 'index'])->name('product.all');
    Route::get("user/all", [UserController::class, 'index'])->name('user.all');
    
    Route::put("token/all", [ApiTokenController::class, 'index'])->name('token.all');
    Route::put("token", [ApiTokenController::class, 'update'])->name('token.update');
    Route::delete("token", [ApiTokenController::class, 'destroy'])->name('token.destroy');
    Route::resource('token', ApiTokenController::class)->except(['create', 'edit', 'update','destroy','index']);

    Route::resource('photo', PhotoController::class)->except(['create', 'edit', 'update']);

    Route::get("shipping", [ShippingController::class, 'index'])->name('shipping.all');
});

//User Routes
Route::middleware(['token_check', 'user'])->group(function () {
    Route::get("user/", [UserController::class, 'show'])->name('user.get');
    Route::put("user/", [UserController::class, 'update'])->name('user.update');
    Route::delete("user/", [UserController::class, 'destroy'])->name('user.destroy');
    Route::get("user/shipping", [UserController::class, 'getShippingInfo'])->name('user.shipping');
    Route::get("user/cart", [UserController::class, 'getCartInfo'])->name('user.cart');
    Route::get("user/totalSale", [UserController::class, 'totalSales'])->name('user.totalSales');
    Route::get("user/orders", [UserController::class, 'getOrders'])->name('user.orders');
    
    Route::get("cart/user/", [CartController::class, 'cartByUser'])->name('cart.user');
    Route::put("cart", [CartController::class, 'update'])->name('cart.update');
    Route::delete("cart", [CartController::class, 'destroy'])->name('cart.destory');

    Route::post("order", [OrderController::class, 'store'])->name('order.create');

    Route::resource('shipping', ShippingController::class)->except(['create', 'edit', 'index']);
});

//Global Routes
Route::middleware('token_check')->group(function () {
    Route::post("user/login", [UserController::class, 'login'])->name('user.login');
    Route::post("admin/login", [AdminController::class, 'login'])->name('admin.login');
    Route::post("user/", [UserController::class, 'store'])->name('user.create');
    Route::get("product/featured", [ProductController::class, 'featured'])->name('product.featured');
    Route::get("product/available", [ProductController::class, 'available'])->name('product.avaliable');
    Route::get("product/{product_id}", [ProductController::class, 'show'])->name('product.show');
    Route::get("product/search/{search}", [ProductController::class, 'search'])->name('product.search');

    Route::get("cart/session", [CartController::class, 'cartBySession'])->name('cart.session');
    Route::post("cart", [CartController::class, 'store'])->name('cart.create');
});




