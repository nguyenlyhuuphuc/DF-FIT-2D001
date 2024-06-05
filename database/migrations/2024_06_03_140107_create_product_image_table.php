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
        Schema::create('product_image', function (Blueprint $table) {
            $table->id();
            $table->string('image_url', 255);
            $table->timestamps();
        });

        Schema::table('product_image', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_image', function (Blueprint $table) {
            $table->dropForeign('product_image_product_id_foreign');
            $table->dropColumn('product_id');
        });
        
        Schema::dropIfExists('product_image');
    }
};
