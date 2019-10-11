<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTeamPivotTable extends Migration
{
    public function up()
    {
        Schema::create('email_team', function (Blueprint $table) {
            $table->unsignedInteger('email_id');
            $table->foreign('email_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedInteger('team_id');
            $table->foreign('team_id')->references('id')->on('emails')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();

            $table->primary(['email_id', 'team_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_team');
    }
}
