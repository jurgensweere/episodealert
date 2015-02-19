<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropKeysIndices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE  `episodes` DROP INDEX  `tvdb_id`');
		DB::statement('ALTER TABLE  `episodes` DROP INDEX  `airdate`');
		DB::statement('ALTER TABLE  `episodes` DROP INDEX  `tvserie_id`');
		DB::statement('ALTER TABLE  `episodes` DROP INDEX  `season`');
		DB::statement('ALTER TABLE  `episodes` DROP INDEX  `episode`');
		
		DB::statement('ALTER TABLE  `following` DROP INDEX  `user_id`');

		DB::statement('ALTER TABLE  `seen` DROP INDEX  `fk_user_id`');
		DB::statement('ALTER TABLE  `seen` DROP INDEX  `fk_serie_id`');
		DB::statement('ALTER TABLE  `seen` DROP INDEX  `season_id`');
		DB::statement('ALTER TABLE  `seen` DROP INDEX  `fk_episode_id`');
		DB::statement('ALTER TABLE  `seen` DROP INDEX  `episode_id`');

		DB::statement('ALTER TABLE  `series` DROP INDEX  `tvdb_id`');
		DB::statement('ALTER TABLE  `series` DROP INDEX  `unique_name`');
		DB::statement('ALTER TABLE  `series` DROP INDEX  `name`');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// There is no way back
	}

}
