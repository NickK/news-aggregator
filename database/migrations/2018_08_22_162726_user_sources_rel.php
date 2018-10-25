<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserSourcesRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('userSourcesRel', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('userSourcesRelID');
            $table->integer('userID');
            $table->integer('sourceID');
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
        Schema::dropIfExists('userSourcesRel');
    }
}
