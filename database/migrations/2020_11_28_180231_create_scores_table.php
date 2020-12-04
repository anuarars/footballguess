<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');
            $table->integer('HThomeTeam')->nullable();
            $table->integer('HTawayTeam')->nullable();
            $table->integer('FThomeTeam')->nullable();
            $table->integer('FTawayTeam')->nullable();
            $table->integer('EThomeTeam')->nullable();
            $table->integer('ETawayTeam')->nullable();
            $table->integer('PThomeTeam')->nullable();
            $table->integer('PTawayTeam')->nullable();
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
        Schema::dropIfExists('scores');
    }
}
