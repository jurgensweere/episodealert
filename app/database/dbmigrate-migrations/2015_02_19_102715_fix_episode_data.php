<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEpisodeData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// We are going to fix the episode data
		// The series_id needs to be equal to the tvdb_id of the series
		DB::statement('UPDATE `episode` e JOIN `series` s ON s.id = e.tvserie_id SET e.series_id = s.tvdb_id;');
		
        // The tvdb_id needs to become the id column.
        DB::statement('ALTER TABLE `episode` CHANGE `id` `old_id` int(10) unsigned NOT NULL AUTO_INCREMENT;');
        DB::statement('ALTER TABLE `episode` CHANGE `tvdb_id` `id` int(10) unsigned NOT NULL AFTER `old_id`;');
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
