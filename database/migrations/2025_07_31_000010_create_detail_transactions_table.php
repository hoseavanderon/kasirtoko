<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('qty');
            $table->string('harga_satuan'); // gunakan string karena Anda ingin pakai varchar untuk harga
            $table->string('subtotal');     // sama dengan harga_satuan, pakai string
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transactions');
    }
};
