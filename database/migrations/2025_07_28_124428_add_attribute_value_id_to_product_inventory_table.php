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
        Schema::table('product_inventory', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_value_id')->after('product_id')->nullable();
            $table->foreign('attribute_value_id')
                ->references('id')
                ->on('product_attribute_values')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_inventory', function (Blueprint $table) {
            $table->dropForeign(['attribute_value_id']);
            $table->dropColumn('attribute_value_id');
        });
    }
};
