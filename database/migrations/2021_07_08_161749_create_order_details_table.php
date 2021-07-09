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
            $table->increments('id');
            $table->unsignedInteger('i_order_id');
            $table->foreign('i_order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->unsignedInteger('i_product_id');
            $table->foreign('i_product_id')->references('id')->on('products');
            $table->integer('i_quantity')->default(1);
            $table->integer('i_price');
            $table->integer('i_total');
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
        Schema::dropIfExists('order_details');
    }
}
