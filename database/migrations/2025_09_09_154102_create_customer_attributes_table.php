<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_attributes', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel customers
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');
            
            $table->string('attribute'); // nama atribut, misal: "Telp", "Email"
            $table->string('attribute_value'); // nilai atribut, misal: nomor telepon/email
            $table->text('attribute_notes')->nullable(); // catatan tambahan
            
            $table->timestamps();
            $table->softDeletes(); // jika ingin soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_attributes');
    }
};