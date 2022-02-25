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

            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files')
                ->onUpdate('restrict')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_attachments');
    }
}
