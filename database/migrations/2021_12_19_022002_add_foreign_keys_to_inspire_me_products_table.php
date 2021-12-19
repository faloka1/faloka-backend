<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToInspireMeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspire_me_products', function (Blueprint $table) {
            $table->foreign(['inspire_me_id'])->references(['id'])->on('inspire_mes');
            $table->foreign(['product_id'])->references(['id'])->on('products');
            $table->foreign(['variant_id'])->references(['id'])->on('variants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspire_me_products', function (Blueprint $table) {
            $table->dropForeign('inspire_me_products_inspire_me_id_foreign');
            $table->dropForeign('inspire_me_products_product_id_foreign');
            $table->dropForeign('inspire_me_products_variant_id_foreign');
        });
    }
}
