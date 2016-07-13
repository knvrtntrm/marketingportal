<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryitemRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventoryitem_request', function(Blueprint $table){

            $table->integer('inventoryitem_id')->unsigned();
            $table->integer('request_id')->unsigned();
            $table->integer('amount')->unsigned();

            $table->foreign('inventoryitem_id')->references('id')->on('inventoryitems')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inventoryitem_request');
    }
}
