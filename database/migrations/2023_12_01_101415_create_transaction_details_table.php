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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            //transaction_id, product_id, qty, price, total
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
