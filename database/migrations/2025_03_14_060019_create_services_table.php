<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); 
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
