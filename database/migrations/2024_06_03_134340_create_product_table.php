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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->float('price', 8, 2, true);
            $table->string('short_description', 255)->nullable();
            $table->integer('qty')->unsigned();
            $table->string('shipping', 255)->nullable();
            $table->float('weight', 8, 2, true);
            $table->string('image_url', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('information')->nullable();
            $table->text('review')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
