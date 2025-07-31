<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_brand_product', function (Blueprint $table) {
            $table->foreignId('digital_brand_id')->constrained('digital_brands')->onDelete('cascade');
            $table->foreignId('digital_product_id')->constrained('digital_products')->onDelete('cascade');
            $table->primary(['digital_brand_id', 'digital_product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_brand_product');
    }
};
