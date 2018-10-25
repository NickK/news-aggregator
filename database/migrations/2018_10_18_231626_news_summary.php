<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewsSummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('newsSummary', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('nsummaryID');
            $table->integer('sourceLinkID');
            $table->integer('userID');
            $table->integer('tagID');            
            $table->tinyInteger('points');
            $table->unique(['sourceLinkID', 'userID', 'tagID']);            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('newsSummary');        
    }
}
