<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SourceLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sourceLinks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('sourceLinkID');
            $table->integer('sourceID');
            $table->string('sourceLink');
            $table->string('sourceTitle')->nullable();
            $table->dateTime('sourceDate')->nullable();
            $table->longText('sourceRaw')->nullable();
            $table->timestamps();
            $table->tinyInteger('active')->default(0);
            $table->unique(['sourceID', 'sourceLink']);
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
        Schema::dropIfExists('sourceLinks');        
    }
}
