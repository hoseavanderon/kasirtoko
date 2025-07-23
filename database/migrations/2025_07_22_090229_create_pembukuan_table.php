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
        Schema::create('pembukuan', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi');
            $table->enum('type', ['In', 'Out']);
            $table->integer('nominal');
            $table->integer('sisa_saldo');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembukuan');
    }
};
