<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('email_recipients', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('email_id')->unsigned();
            $table->foreign('email_id')->references('id')->on('emails');

            $table->integer('recipient_id')->unsigned();
            $table->foreign('recipient_id')->references('id')->on('users');

            $table->tinyInteger('type')->unsigned();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_recipients');
    }
}
