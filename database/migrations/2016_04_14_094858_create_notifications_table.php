<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function(Blueprint $table){

            $table->increments('id');
            $table->integer('client_id');
            $table->integer('code');
            $table->string('message');
            $table->integer('read');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *!
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }
}
