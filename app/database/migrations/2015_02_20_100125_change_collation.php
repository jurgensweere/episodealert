<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCollation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `episode`  CHARACTER SET = utf8 , COLLATE = utf8_unicode_ci ;');
		DB::statement('ALTER TABLE `seen`  CHARACTER SET = utf8 , COLLATE = utf8_unicode_ci ;');
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
