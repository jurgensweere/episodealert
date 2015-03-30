<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('mail_log')) {
			return;
		}
		Schema::create('mail_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type', 45);
			$table->longText('content')->nullable();
			$table->string('recipient', 150);
			$table->boolean('status');
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
		Schema::drop('mail_log');
	}

}
