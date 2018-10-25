<?php

use Illuminate\Database\Seeder;

class sources extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('sources')->insert([
	        [
				'sourceName' => 'Polygon',
				'domain' => 'polygon.com',
				'sourceMainURL' => 'https://www.polygon.com/',
				'aggregator' => 0

	        ],
	        [
				'sourceName' => 'Rock Paper Shotgun',
				'domain' => 'rockpapershotgun.com',
				'sourceMainURL' => 'https://www.rockpapershotgun.com/',
				'aggregator' => 0

	        ],

	        [
				'sourceName' => 'PC Gamer',
				'domain' => 'pcgamer.com',
				'sourceMainURL' => 'https://www.pcgamer.com/',
				'aggregator' => 0

	        ],
	        [
				'sourceName' => 'The Next Web',
				'domain' => 'thenextweb.com',
				'sourceMainURL' => 'https://thenextweb.com/latest/',
				'aggregator' => 0

	        ],
	        [
				'sourceName' => 'CBC',
				'domain' => 'cbc.ca',
				'sourceMainURL' => 'http://www.cbc.ca/news',
				'aggregator' => 0
	        ],
	        [
				'sourceName' => 'BBC',
				'domain' => 'bbc.com',
				'sourceMainURL' => 'http://www.bbc.com/news',
				'aggregator' => 0
	        ],
	        [
				'sourceName' => 'The Guardian',
				'domain' => 'theguardian.com',
				'sourceMainURL' => 'https://www.theguardian.com/international',
				'aggregator' => 0
	        ]

    	]);


    }
}
