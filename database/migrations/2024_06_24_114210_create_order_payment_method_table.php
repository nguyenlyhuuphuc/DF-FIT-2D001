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
        Schema::create('order_payment_method', function (Blueprint $table) {
            $table->id();
            $table->float('total')->nullable();
            $table->string('payment_method', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('reason', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payment_method');
    }
};
