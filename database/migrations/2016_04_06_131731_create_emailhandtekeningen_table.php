<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmailhandtekeningenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailhandtekeningen', function(Blueprint $table){

            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('function');
            $table->string('image');
            $table->integer('approved');
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
        Schema::drop('emailhandtekeningen');
    }
}
