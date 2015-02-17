<?php

use EA\models\User;
use EA\models\Following;
use EA\models\Series;
use Faker\Factory as Faker;

class TestSeeder extends Seeder{

	public function run(){
		$faker = Faker::create();
		$amountOfUsers = 500;
		$amountOfFollowingPerUser = 50;

		//Delete all users
		foreach (User::all() as $user) {
			$user->delete();
		}

		//create x users
		foreach(range(1, $amountOfUsers) as $index){

			User::create(array(
	            'accountname' => $faker->firstName,
	            'password' => Hash::make('test'),
	            'username' => $faker->userName,
	            'email' => $faker->email,
	            'registered' => '1',
	            'publicfollow' => '1',
	            'showonlyrunning' => '1',
	            'role' => 'user'				
			));
		}

		$allUsers = User::all();
		//create super following
		foreach($allUsers as $user){

			//follow x random series
			foreach(range(1, $amountOfFollowingPerUser) as $index){
				$series = Series::orderByRaw("RAND()")->first();
				
				Following::create(array(
					'series_id' => $series->id,
				 	'user_id' => $user->id
				));
			}


		}
	}
}
