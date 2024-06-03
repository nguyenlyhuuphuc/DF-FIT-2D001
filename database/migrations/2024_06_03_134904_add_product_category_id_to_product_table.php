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
        Schema::table('product', function (Blueprint $table) {
            //product_category_id -> (FK) -> product_category(id)
            //B1 :
            $table->unsignedBigInteger('product_category_id');

            //B2: 
            $table->foreign('product_category_id')->references('id')->on('product_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign('product_product_category_id_foreign');
            $table->dropColumn('product_category_id');
        });
    }
};
