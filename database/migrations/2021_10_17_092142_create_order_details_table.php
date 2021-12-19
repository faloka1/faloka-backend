<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->integer('order_brand_id');
            $table->unsignedBigInteger('order_id')->index('order_id');
            $table->unsignedBigInteger('variant_id')->index('product_id');
            $table->unsignedBigInteger('product_id')->nullable()->index('product_id_2');
            $table->unsignedBigInteger('variantsize_id')->index('variantsize_id');
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
        Schema::dropIfExists('order_details');
    }
}
