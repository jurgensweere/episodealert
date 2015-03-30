<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('seen')) {
			return;
		}
		Schema::create('seen', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('seen_user_id_foreign');
			$table->integer('series_id')->unsigned()->index('seen_series_id_foreign');
			$table->integer('episode_id')->unsigned()->index('seen_episode_id_foreign');
			$table->integer('season')->index('index_season_n');
			$table->integer('episode')->index('index_episode_n');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('seen');
	}

}
