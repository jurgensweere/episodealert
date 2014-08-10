<?php

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->delete();

        //User::create(array('email' => 'foo@bar.com'));
    }
}
