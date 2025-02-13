<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Category;
use App\Models\Photo;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory(10)->create();
        Admin::factory(10)->create();
        Category::factory(10)->create();
        Product::factory(10)->create();
        Cart::factory(10)->create();
        Order::factory(10)->create();
        OrderItem::factory(10)->create();
        Shipping::factory(10)->create();
        Photo::factory(20)->create();
    }
}
