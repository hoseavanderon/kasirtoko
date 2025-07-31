<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembukuans', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi');
            $table->enum('type', ['IN', 'OUT']);
            $table->unsignedBigInteger('nominal');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_pembukuan_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembukuan');
    }
};
