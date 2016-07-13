<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promoitems', function(Blueprint $table){

            $table->increments('id');
            $table->integer('code')->unsigned()->unique();
            $table->string('name');
            $table->integer('pack');
            $table->float('price')->unsigned();
            $table->integer('amountinstock')->unsigned();
            $table->string('image');
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
