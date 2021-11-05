<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('order_id');
            $table->float('shipping_price');
            $table->string('expedition_name');
            $table->string('service');
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
        Schema::dropIfExists('shipings');
    }
}
