<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');

            $table->string('subject');
            $table->text('body')->nullable();
            $table->unsignedTinyInteger('priority');
            $table->unsignedTinyInteger('send_to');

            $table->dateTime('schedule_at')->nullable();
            $table->dateTime('sent_at')->nullable();

            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
