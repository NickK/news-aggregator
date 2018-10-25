<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sources', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('sourceID');
            $table->string('sourceName');
            $table->string('domain');            
            $table->string('sourceMainURL');
            $table->tinyInteger('aggregator')->default(0);
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
        Schema::dropIfExists('sources');
    }
}
