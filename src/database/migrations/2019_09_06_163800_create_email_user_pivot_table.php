<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('email_recipients', function (Blueprint $table) {
            $table->unsignedInteger('email_id');
            $table->foreign('email_id')->references('id')->on('emails')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedInteger('recipient_id');
            $table->foreign('recipient_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->tinyInteger('type')->unsigned();

            $table->timestamps();

            $table->primary(['email_id', 'recipient_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_recipients');
    }
}
