<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixUserData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// figure out who was a google user
		DB::statement('UPDATE `user` set `oauthprovider` = \'google\' where `old_accountname` like \'https://www.google.com%\';');

		// make the account name, the old_username
		DB::statement('UPDATE `user` set `accountname` = `old_username`;');

		// set the usernames for those who don't user google
		DB::statement('UPDATE `user` set `username` = `old_username` where `old_accountname` not like \'https://www.google.com%\';');

		// Update the following counter
        DB::statement('UPDATE `user` SET following = (SELECT COUNT(id) FROM following WHERE user.id = following.user_id GROUP BY user_id);');

        // Drop unused column
        DB::statement('ALTER TABLE `user` DROP COLUMN `old_username`;');
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
