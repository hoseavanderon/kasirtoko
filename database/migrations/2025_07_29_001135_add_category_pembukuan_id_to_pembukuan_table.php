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
        Schema::table('pembukuan', function (Blueprint $table) {
            if (!Schema::hasColumn('pembukuan', 'category_pembukuan_id')) {
                $table->foreignId('category_pembukuan_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('category_pembukuans')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembukuan', function (Blueprint $table) {
            $table->dropForeign(['category_pembukuan_id']);
            $table->dropColumn('category_pembukuan_id');
        });
    }
};
