<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(sources::class);
        $this->call(users::class);
        $this->call(userSourcesRel::class);
        $this->call(userTagsRel::class);     
        $this->call(tags::class);
        //$this->call(sourceTagsRel::class);      
    }
}
