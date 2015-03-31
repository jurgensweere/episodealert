<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFollowingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('following')) {
			return;
		}
		Schema::create('following', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('series_id')->unsigned()->index('following_series_id_foreign');
			$table->integer('user_id')->unsigned()->index('following_user_id_foreign');
			$table->boolean('archive')->default(0);
			$table->date('last_notified')->nullable();
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
		Schema::drop('following');
	}

}
