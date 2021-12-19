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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inspire_me_id')->index('inspire_me_products_inspire_me_id_foreign');
            $table->unsignedBigInteger('product_id')->index('inspire_me_products_product_id_foreign');
            $table->unsignedBigInteger('variant_id')->index('inspire_me_products_variant_id_foreign');
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
