<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guesses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('schedule_id');
            $table->integer('matchday');
            $table->integer('homeTeamId');
            $table->integer('awayTeamId');
            $table->integer('FThomeTeam')->nullable();
            $table->integer('FTawayTeam')->nullable();
            $table->integer('points')->nullable();
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
        Schema::dropIfExists('guesses');
    }
}
