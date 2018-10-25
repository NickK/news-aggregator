<?php

use Illuminate\Database\Seeder;

class userTagsRel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        for ($i = 1; $i <= 15; $i++) {
        	$insert[] = array(
        		'tagID' => $i,
        		'userID' => 1
        	);
        }
        DB::table('userTagsRel')->insert($insert);

    }
}
