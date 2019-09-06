<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('email_id')->unsigned();
            $table->foreign('email_id')->references('id')->on('emails');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_attachments');
    }
}
