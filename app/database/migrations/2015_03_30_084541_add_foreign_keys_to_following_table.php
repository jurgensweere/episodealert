<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFollowingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		try { 
			Schema::table('following', function(Blueprint $table)
			{
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
		Schema::table('following', function(Blueprint $table)
		{
			$table->dropForeign('following_series_id_foreign');
			$table->dropForeign('following_user_id_foreign');
		});
	}

}
