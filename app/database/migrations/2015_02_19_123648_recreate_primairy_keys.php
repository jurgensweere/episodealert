<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreatePrimairyKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// we are now going to drop the old pk and create new ones.

		// series
		DB::statement('ALTER TABLE `series` CHANGE `old_id` `old_id` int(10) unsigned NOT NULL;');
		DB::statement('ALTER TABLE `series` DROP PRIMARY KEY;');
		// make sure we delete duplicates!
		DB::statement('ALTER IGNORE TABLE `series` ADD UNIQUE INDEX `id_UNIQUE` (`id` ASC);');
        DB::statement('ALTER TABLE `series` ADD PRIMARY KEY (id);');
        DB::statement('ALTER TABLE `series` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;');
		DB::statement('ALTER TABLE `series` DROP COLUMN `old_id`;');

		// episodes
		DB::statement('ALTER TABLE `episode` CHANGE `old_id` `old_id` int(10) unsigned NOT NULL;');
		DB::statement('ALTER TABLE `episode` DROP PRIMARY KEY;');
		// make sure we delete duplicates!
		DB::statement('ALTER IGNORE TABLE `episode` ADD UNIQUE INDEX `id_UNIQUE` (`id` ASC);');
        DB::statement('ALTER TABLE `episode` ADD PRIMARY KEY (id);');
        DB::statement('ALTER TABLE `episode` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;');
        DB::statement('ALTER TABLE `episode` DROP COLUMN `old_id`;');
        DB::statement('ALTER TABLE `episode` DROP COLUMN `tvserie_id`;');

        DB::statement('ALTER TABLE `seen` DROP COLUMN `tvserie_id`;');
		DB::statement('ALTER TABLE `seen` DROP COLUMN `oldepisode_id`;');

		DB::statement('ALTER TABLE `following` DROP COLUMN `tvserie_id`;');
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
