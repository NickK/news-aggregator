<?php

use Illuminate\Database\Seeder;

class userSourcesRel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $insert = array();
        for ($i = 1; $i <= 7; $i++) {
        	$insert[] = array(
        		'userID' => 1,
        		'sourceID' => $i
        	);
        }
        DB::table('userSourcesRel')->insert($insert);

        
    }
}
