<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('attachable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_attachments');
    }
}
