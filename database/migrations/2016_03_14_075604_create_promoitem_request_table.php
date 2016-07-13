<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoitemRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promoitem_promorequest', function(Blueprint $table){

            $table->integer('promoitem_id')->unsigned();
            $table->integer('promorequest_id')->unsigned();
            $table->integer('amount')->unsigned();
            $table->integer('amountDone')->unsigned();

            $table->foreign('promoitem_id')->references('id')->on('promoitems')->onDelete('cascade');
            $table->foreign('promorequest_id')->references('id')->on('promorequests')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('promoitem_promorequest');
    }
}
