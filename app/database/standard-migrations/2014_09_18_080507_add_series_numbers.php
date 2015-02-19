<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeriesNumbers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('series', function ($table) {
            $table->integer('season_amount')->unsigned()->nullable();
            $table->integer('episode_amount')->unsigned()->nullable();
            $table->boolean('has_specials')->default(0);
        });		
		
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
