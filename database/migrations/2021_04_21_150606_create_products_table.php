<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('s_name_en');
            $table->string('s_description_en');
            $table->string('s_store_en')->nullable();

            $table->string('s_name_ar');
            $table->string('s_description_ar');
            $table->string('s_store_ar')->nullable();

            $table->string('s_image');

            $table->boolean('b_is_offer')->default(false);
            $table->boolean('b_is_favorite')->default(false);
            $table->integer('f_old_price');
            $table->integer('f_new_price')->nullable();

            $table->unsignedInteger('i_category_id');
            $table->foreign('i_category_id')->references('id')->on('categories');
            $table->softDeletes();
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
}
