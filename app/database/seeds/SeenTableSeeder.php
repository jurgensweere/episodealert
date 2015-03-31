<?php

class SeenTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('seen')->delete();
        
		\DB::table('seen')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 1,
				'series_id' => 72449,
				'episode_id' => 85773,
				'season' => 2,
				'episode' => 1,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
