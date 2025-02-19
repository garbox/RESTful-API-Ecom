<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void{
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->integer('role_id');
            $table->integer("permissions");
            $table->string('password');
            $table->string('api_token');
            $table->timestamp('created_at')->useCurrent();    
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void{
        Schema::dropIfExists('admins');
    }
};
