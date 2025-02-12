<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ProductType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->mediumText('short_description');
            $table->integer('price');
            $table->foreignIdFor(ProductType::class)->constrained()->onDelete('cascade');
            $table->mediumText('long_description');
            $table->boolean('featured');
            $table->boolean('available');
            $table->timestamp('created_at')->useCurrent(); 
            $table->timestamp('updated_at')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
