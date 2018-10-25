<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTagsRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('userTagsRel', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('userTagRelID');
            $table->integer('tagID');
            $table->integer('userID');
            $table->unique(['tagID', 'userID']);            
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
        Schema::dropIfExists('userTagsRel');        
    }
}
