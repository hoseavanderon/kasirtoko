<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_attribute_values', function (Blueprint $table) {
            $table->integer('stok')->default(0)->after('attribute_value');
            $table->date('last_restock_date')->nullable()->after('stok');
            $table->date('last_sale_date')->nullable()->after('last_restock_date');
            $table->integer('minimal_stok')->default(0)->after('last_sale_date');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('minimal_stok');
        });

        Schema::dropIfExists('product_inventory');
    }

    public function down(): void
    {
        Schema::create('product_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->date('last_restock_date')->nullable();
            $table->date('last_sale_date')->nullable();
            $table->integer('minimal_stok')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('product_attribute_values', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['user_id']);

            // Baru hapus kolom-kolomnya
            $table->dropColumn([
                'stok',
                'last_restock_date',
                'last_sale_date',
                'minimal_stok',
                'user_id',
            ]);
        });
    }
};
