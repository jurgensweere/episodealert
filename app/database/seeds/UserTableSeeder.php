<?php

use EA\models\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->delete();

        User::create(array(
            'old_accountname' => '',
            'old_password' => '',
            'accountname' => 'episodealert',
            'password' => Hash::make('kaas123'),
            'email' => 'episodealert@gmail.com',
            'registered' => '1',
            'publicfollow' => '1',
            'showonlyrunning' => '1',
            'role' => 'admin'
        ));        


        User::create(array(
            'old_accountname' => '',
            'old_password' => '',
            'accountname' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@episode-alert.com',
            'registered' => '1',
            'publicfollow' => '1',
            'showonlyrunning' => '1',
            'role' => 'admin'
        ));      

    }
}
