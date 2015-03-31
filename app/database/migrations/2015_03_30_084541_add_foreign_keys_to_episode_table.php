<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEpisodeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		try { 
			Schema::table('episode', function(Blueprint $table)
			{
				$table->foreign('series_id')->references('id')->on('series')->onUpdate('RESTRICT')->onDelete('CASCADE');
			});
		} catch (Exception $e) {
			return;
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('episode', function(Blueprint $table)
		{
			$table->dropForeign('episode_series_id_foreign');
		});
	}

}
