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
        Schema::table('product_attribute_values', function (Blueprint $table) {
            $table->dropColumn('minimal_stok');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('minimal_stok')->default(0)->after('jual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('minimal_stok');
        });

        Schema::table('product_attribute_values', function (Blueprint $table) {
            $table->integer('minimal_stok')->default(0)->after('stok');
        });
    }
};
