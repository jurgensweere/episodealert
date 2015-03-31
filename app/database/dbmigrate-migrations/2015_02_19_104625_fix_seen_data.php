<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSeenData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// We are going to fix the seen data
		// The series_id needs to be equal to the tvdb_id of the series
		DB::statement('UPDATE `seen` s JOIN `episode` e ON e.old_id = s.oldepisode_id SET s.series_id = e.series_id, s.episode_id = e.id;');
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
