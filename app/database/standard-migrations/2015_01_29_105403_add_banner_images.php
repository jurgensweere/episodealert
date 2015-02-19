<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBannerImages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('series', function ($table) {
            $table->string('banner_image', 64)->nullable()->default(null)->after('fanart_image_converted');
            $table->boolean('banner_image_converted')->default(0)->after('banner_image');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('series', function ($table) {
            $table->dropColumn('banner_image');
            $table->dropColumn('banner_image_converted');
        });
	}

}
