<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->foreign(['product_id'], 'carts_ibfk_1')->references(['id'])->on('products')->onDelete('CASCADE');
            $table->foreign(['variant_id'], 'carts_ibfk_2')->references(['id'])->on('variants')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'carts_ibfk_3')->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['variantsize_id'], 'carts_ibfk_4')->references(['id'])->on('variant_sizes')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_ibfk_1');
            $table->dropForeign('carts_ibfk_2');
            $table->dropForeign('carts_ibfk_3');
            $table->dropForeign('carts_ibfk_4');
        });
    }
}
