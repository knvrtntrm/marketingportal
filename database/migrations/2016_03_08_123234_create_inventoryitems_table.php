<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventoryitems', function(Blueprint $table){

            $table->increments('id');
            $table->integer('code')->unsigned()->unique();
            $table->string('name');
            $table->integer('client_id')->unsigned();
            $table->integer('condition_id')->unsigned();
            $table->string('image');
            $table->integer('amount')->unsigned();
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
        //
    }
}
