<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOauthType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user', function ($table) {
            $table->enum('oauthprovider', array('google', 'facebook'))->nullable()->default(null)->after('accountname');
            $table->string('oauthid', 100)->nullable()->default(null)->after('oauthprovider');
        });
        DB::update('update user set accountname = username');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user', function ($table) {
            $table->dropColumn('oauthprovider');
            $table->dropColumn('oauthid');
        });
	}

}
