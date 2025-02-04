<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Order;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->foreignIdFor(Order::class)->references('id')->on('orders');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->integer('zip');
            $table->string('city');
            $table->string('state');
            $table->timestamp('created_at')->useCurrent();  
            $table->timestamp('updated_at')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
