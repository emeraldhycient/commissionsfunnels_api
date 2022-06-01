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
        Schema::create('dispatchers', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_phone');
            $table->string('company_email');
            $table->string('company_website')->nullable();
            $table->string('company_images');
            $table->string('company_representative');
            $table->string('company_representative_phone');
            $table->string('delivery_fee');
            $table->string('company_location');
            $table->string('company_delivery_zone');
            $table->string('user_id');
            $table->boolean('company_status')->default(0);
            $table->date('next_payment_date');
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
        Schema::dropIfExists('dispatchers');
    }
};