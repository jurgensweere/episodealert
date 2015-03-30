<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEpisodeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('episode')) {
			return;
		}
		Schema::create('episode', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('series_id')->unsigned()->index('episode_series_id_foreign');
			$table->integer('season');
			$table->integer('episode');
			$table->dateTime('airdate')->nullable();
			$table->string('name', 200)->default('untitled');
			$table->text('description');
			$table->string('image');
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
		Schema::drop('episode');
	}

}
