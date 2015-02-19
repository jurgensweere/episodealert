<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixFollowingData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// We are going to fix the following data
		// The series_id needs to be equal to the tvdb_id of the series
		DB::statement('UPDATE `following` f JOIN `series` s ON s.id = f.tvserie_id SET f.series_id = s.tvdb_id;');
		
		// Some series have gone missing, we will delete those records.
		DB::statement('DELETE FROM `following` WHERE `series_id` = 0;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
