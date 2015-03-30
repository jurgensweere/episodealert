<?php

use EA\models\User;
use EA\models\Following;
use EA\models\Series;
use Faker\Factory as Faker;

class TestDataSeeder extends Seeder{

	public function run(){
		$faker = Faker::create();
		$amountOfUsers = 3000;

		//Delete all users
		foreach (User::all() as $user) {
			$user->delete();
		}

		//create x users
		foreach(range(1, $amountOfUsers) as $index){

			User::create(array(
				'old_accountname' => '',
            	'old_password' => '',
	            'accountname' => $faker->firstName,
	            'password' => Hash::make('test'),
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

			//follow some random amount
			$amountOfFollowingPerUser = rand(10, 80);

			//follow x random series
			foreach(range(1, $amountOfFollowingPerUser) as $index){
				$series = Series::orderByRaw("RAND()")->first();
				
				Following::create(array(
					'series_id' => $series->id,
				 	'user_id' => $user->id,
				 	'created_at' => $faker->dateTimeThisMonth($max = 'now')
				));
			}


		}
	}
}
