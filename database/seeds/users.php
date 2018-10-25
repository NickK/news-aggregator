<?php

use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $insert[] = array(
            'email' => 'nick@email.com',
            'password' => bcrypt('password123'),
            'remember_token' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        DB::table('users')->insert($insert);

        
    }
}
