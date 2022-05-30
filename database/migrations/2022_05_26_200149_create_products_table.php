<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name');
            $table->string('product_description');
            $table->integer('product_price');
            $table->text('product_image');
            $table->string('product_category');
            $table->integer('product_quantity');
            $table->string('product_commission');
            $table->string('product_seller');
            $table->longText('sales_copy');
            $table->string('product_delivery');
            $table->string('product_status')->default('available');
            $table->boolean('is_approved')->default(0);
            $table->integer('sold')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};