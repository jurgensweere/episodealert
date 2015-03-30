<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSeenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		try {
			Schema::table('seen', function(Blueprint $table)
			{
				$table->foreign('episode_id')->references('id')->on('episode')->onUpdate('RESTRICT')->onDelete('CASCADE');
				$table->foreign('series_id')->references('id')->on('series')->onUpdate('RESTRICT')->onDelete('CASCADE');
				$table->foreign('user_id')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
		Schema::table('seen', function(Blueprint $table)
		{
			$table->dropForeign('seen_episode_id_foreign');
			$table->dropForeign('seen_series_id_foreign');
			$table->dropForeign('seen_user_id_foreign');
		});
	}

}
