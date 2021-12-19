<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCategorySubCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_sub_category', function (Blueprint $table) {
            $table->foreign(['sub_category_id'], 'category_sub_category_ibfk_1')->references(['id'])->on('sub_categories')->onUpdate('CASCADE');
            $table->foreign(['category_id'], 'category_sub_category_ibfk_2')->references(['id'])->on('categories')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_sub_category', function (Blueprint $table) {
            $table->dropForeign('category_sub_category_ibfk_1');
            $table->dropForeign('category_sub_category_ibfk_2');
        });
    }
}
