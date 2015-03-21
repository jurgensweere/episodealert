<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrending extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('series', function ($table) {
            $table->integer('trend')->default(0)->after('popular');
        });

        DB::statement('UPDATE series SET trend = (SELECT COUNT(id) FROM following WHERE series.id = following.series_id GROUP BY series_id);');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('series', function ($table) {
            $table->dropColumn('trend');
        });
	}

}
