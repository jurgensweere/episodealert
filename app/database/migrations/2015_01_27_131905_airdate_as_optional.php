<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AirdateAsOptional extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE episode CHANGE COLUMN `airdate` `airdate` DATETIME NULL DEFAULT NULL ;');
		DB::statement("UPDATE episode set airdate = null WHERE airdate = '0000-00-00 00:00:00';");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("UPDATE episode set airdate = '0000-00-00 00:00:00' WHERE airdate is null;");
		DB::statement('ALTER TABLE episode CHANGE COLUMN `airdate` `airdate` DATETIME NOT NULL ;');
	}

}
