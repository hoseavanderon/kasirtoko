<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('digital_products', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('digital_category_id')->constrained('digital_categories')->onDelete('cascade'); // Foreign key ke digital_categories
            $table->string('name'); 
            $table->timestamps(); 
            $table->unique(['digital_category_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_products');
    }
};