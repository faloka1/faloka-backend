<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspireMeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspire_me_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspire_me_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id');
            // foreign keys
            $table->foreign('inspire_me_id')->references('id')->on('inspire_mes');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variant_id')->references('id')->on('variants');
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
        Schema::dropIfExists('inspire_me_products');
    }
}
