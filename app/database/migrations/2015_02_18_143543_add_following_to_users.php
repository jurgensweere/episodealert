<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFollowingToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user', function ($table) {
            $table->integer('following')->default(0)->after('registered');
        });

        // Update the current users
        DB::statement('UPDATE user SET following = (SELECT COUNT(id) FROM following WHERE user.id = following.user_id GROUP BY user_id);');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user', function ($table) {
            $table->dropColumn('following');
        });
	}

}
