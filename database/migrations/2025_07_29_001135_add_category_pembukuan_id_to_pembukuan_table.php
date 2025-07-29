<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pembukuan', function (Blueprint $table) {
            $table->foreignId('category_pembukuan_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pembukuan', function (Blueprint $table) {
            $table->dropForeign(['category_pembukuan_id']);
            $table->dropColumn('category_pembukuan_id');
        });
    }
};
