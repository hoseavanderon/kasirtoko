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
        Schema::create('digital_transactions', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('digital_product_id')->constrained('digital_products')->onDelete('restrict');
            $table->foreignId('brand_id')->nullable()->constrained('digital_brands')->onDelete('set null'); 
            $table->string('keterangan')->nullable(); 
            $table->integer('harga_jual');
            $table->timestamp('transaction_date')->useCurrent();  
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_transactions');
    }
};