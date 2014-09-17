<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddFanartImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::info("in up method fanart db");
        Schema::table('series', function ($table) {
            $table->string('poster_image', 64)->nullable()->default(null);
            $table->boolean('poster_image_converted')->default(0);
            $table->string('fanart_image', 64)->nullable()->default(null);
            $table->boolean('fanart_image_converted')->default(0);

            $table->dropColumn('image');
            $table->dropColumn('imageconverted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Log::info("in down method fanart db");
       
    }
}
