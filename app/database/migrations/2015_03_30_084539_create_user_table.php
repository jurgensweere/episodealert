<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('user')) {
			return;
		}
		Schema::create('user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('old_accountname', 100);
			$table->string('accountname', 200);
			$table->enum('oauthprovider', array('google','facebook'))->nullable();
			$table->string('oauthid', 100)->nullable();
			$table->string('old_password', 32);
			$table->string('password', 256)->nullable();
			$table->string('email', 150);
			$table->boolean('registered')->default(0);
			$table->integer('following')->default(0);
			$table->boolean('publicfollow')->default(0);
			$table->boolean('alerts')->default(1);
			$table->boolean('showonlyrunning')->default(0);
			$table->string('role', 10)->default('member');
			$table->date('last_notified')->nullable();
			$table->timestamps();
			$table->string('remember_token', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
