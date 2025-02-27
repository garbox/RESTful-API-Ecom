<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
                $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade');
                $table->string('session_id');
                $table->integer('quantity');
                $table->integer('price');
                $table->timestamp('created_at')->useCurrent();    
                $table->timestamp('updated_at')->useCurrent();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
