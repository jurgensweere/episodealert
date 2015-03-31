<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('series')) {
			return;
		}
		Schema::create('series', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('unique_name', 100);
			$table->string('name', 100)->default('untitled');
			$table->longText('description');
			$table->date('firstaired')->nullable();
			$table->string('rating', 10)->nullable();
			$table->dateTime('rating_updated');
			$table->string('imdb_id', 10)->nullable();
			$table->string('poster_image', 128)->nullable();
			$table->boolean('poster_image_converted')->default(0);
			$table->string('fanart_image', 128)->nullable();
			$table->boolean('fanart_image_converted')->default(0);
			$table->string('banner_image', 128)->nullable();
			$table->boolean('banner_image_converted')->default(0);
			$table->string('category', 128);
			$table->string('status', 25)->nullable();
			$table->boolean('popular')->default(0);
			$table->integer('trend')->default(0);
			$table->integer('season_amount')->unsigned()->nullable();
			$table->integer('episode_amount')->unsigned()->nullable();
			$table->boolean('has_specials')->default(0);
			$table->integer('specials_amount')->unsigned()->default(0);
			$table->timestamps();
			$table->index(['imdb_id','status'], 'multi_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('series');
	}

}
