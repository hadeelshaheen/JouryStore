<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('s_order_type',[1,2]);//1->store 2->delivary
            $table->string('s_name');
            $table->string('s_phone');
            $table->string('s_address')->nullable();
            $table->enum('s_status',[0,1])->default(0);//1->Delivered  0->Note
            $table->date('dt_date');
            $table->time('t_time');
            $table->string('s_note')->nullable();
            $table->string('s_store_address')->nullable();
            $table->integer('i_total');
            $table->unsignedInteger('i_user_id');
            $table->foreign('i_user_id')->references('id')->on('users');

//            $table->unsignedInteger('i_product_id');
//            $table->foreign('i_product_id')->references('id')->on('products');

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
        Schema::dropIfExists('orders');
    }
}
