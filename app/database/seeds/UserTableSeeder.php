<?php

use EA\models\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->delete();

        User::create(array(
            'accountname' => '',
            'password' => Hash::make('kaas123'),
            'username' => 'episodealert',
            'email' => 'episodealert@gmail.com',
            'registered' => '1',
            'publicfollow' => '1',
            'showonlyrunning' => '1',
            'role' => 'admin'
        ));        


        User::create(array(
            'accountname' => '',
            'password' => Hash::make('admin'),
            'username' => 'admin',
            'email' => '',
            'registered' => '1',
            'publicfollow' => '1',
            'showonlyrunning' => '1',
            'role' => 'admin'
        ));      

    }
}
