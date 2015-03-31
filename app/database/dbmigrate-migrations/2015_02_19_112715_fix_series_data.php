<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSeriesData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// we forgot to delete some episodes with no series attached
		DB::statement('DELETE FROM episode where series_id = 0;');

		// set season_amount
		DB::statement('UPDATE `series` set season_amount = 0;'); // default everything to 0 seasons
		DB::statement('UPDATE `series` s 
			inner join (
				select series_id, max(season) as season_amount from episode
				group by series_id
			) e on e.series_id = s.tvdb_id
			SET s.season_amount = e.season_amount
		;');

		// set episode_amount
		DB::statement('UPDATE `series` set episode_amount = 0;'); // default everything to 0 episodes
		DB::statement('UPDATE `series` s 
			inner join (
				select series_id, count(id) as episode_amount from episode
				where season > 0
				group by series_id
			) e on e.series_id = s.tvdb_id
			SET s.episode_amount = e.episode_amount
		;');

		// set has_specials
		DB::statement('UPDATE `series` s 
			inner join (
				select distinct(series_id) from episode where season = 0
			) e on e.series_id = s.tvdb_id
			SET s.has_specials = 1
		;');

		// set specials_amount
		DB::statement('UPDATE `series` set specials_amount = 0;'); // default everything to 0 specials
		DB::statement('UPDATE `series` s 
			inner join (
				select series_id, count(id) as specials_amount from episode
				where season = 0
				group by series_id
			) e on e.series_id = s.tvdb_id
			SET s.specials_amount = e.specials_amount
		;');

		// swap the ID
        DB::statement('ALTER TABLE `series` CHANGE `id` `old_id` int(10) unsigned NOT NULL AUTO_INCREMENT;');
        DB::statement('ALTER TABLE `series` CHANGE `tvdb_id` `id` int(10) unsigned NOT NULL AFTER `old_id`;');
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
