<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->foreign(['order_id'], 'order_details_ibfk_1')->references(['id'])->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['variant_id'], 'order_details_ibfk_2')->references(['id'])->on('variants')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['product_id'], 'order_details_ibfk_3')->references(['id'])->on('products')->onDelete('CASCADE');
            $table->foreign(['variantsize_id'], 'order_details_ibfk_4')->references(['id'])->on('variant_sizes')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign('order_details_ibfk_1');
            $table->dropForeign('order_details_ibfk_2');
            $table->dropForeign('order_details_ibfk_3');
            $table->dropForeign('order_details_ibfk_4');
        });
    }
}
