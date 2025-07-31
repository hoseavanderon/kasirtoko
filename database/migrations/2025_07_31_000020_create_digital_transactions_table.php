<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('digital_brand_id')->constrained()->cascadeOnDelete();
            $table->string('keterangan')->nullable();
            $table->string('harga_jual');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_transactions');
    }
};
