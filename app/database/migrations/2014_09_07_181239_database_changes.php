<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseChanges extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('mail_log');
        Schema::drop('seen');
        Schema::drop('setting');
        Schema::drop('following');
        Schema::drop('user');
        Schema::drop('episode');
        Schema::drop('series');
        

        Schema::create('series', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('unique_name', 100);
            $table->string('name', 100);
            $table->text('description');
            $table->date('firstaired');
            $table->string('rating', 10);
            $table->datetime('rating_updated');
            $table->string('imdb_id', 10);
            $table->string('poster_image', 128)->nullable()->default(null);
            $table->boolean('poster_image_converted')->default(0);
            $table->string('fanart_image', 128)->nullable()->default(null);
            $table->boolean('fanart_image_converted')->default(0);
            $table->string('category', 128);            
            $table->string('status', 25)->nullable();
            $table->boolean('popular')->default(0);
            $table->timestamps();

            $table->index(array('imdb_id', 'status'), 'multi_index');
        });

        Schema::create('episode', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('series_id')->unsigned();
            $table->integer('season');
            $table->integer('episode');
            $table->datetime('airdate');
            $table->string('name', 200)->default('untitled');
            $table->text('description');
            $table->string('image', 255);
            $table->timestamps();

            $table->foreign('series_id')
                ->references('id')->on('series')
                ->onDelete('cascade');
        });

        Schema::create('user', function ($table) {
            $table->increments('id');
            $table->string('accountname', 200);
            $table->string('password', 256)->nullable();
            $table->string('username', 100);
            $table->string('email', 150);
            $table->boolean('registered')->default(0);
            $table->boolean('publicfollow')->default(0);
            $table->boolean('showonlyrunning')->default(0);
            $table->string('role', 10)->default('member');
            $table->timestamps();
            $table->rememberToken();
        });

        Schema::create('following', function ($table) {
            $table->increments('id');
            $table->integer('series_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('archive')->default(0);
            $table->timestamps();

            $table->foreign('series_id')
                ->references('id')->on('series')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('cascade');
        });

        Schema::create('setting', function ($table) {
            $table->increments('id');
            $table->string('key', 32);
            $table->string('value', 128);
        });

        Schema::create('seen', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('series_id')->unsigned();
            $table->integer('episode_id')->unsigned();
            $table->integer('season');
            $table->integer('episode');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('cascade');
            $table->foreign('series_id')
                ->references('id')->on('series')
                ->onDelete('cascade');
            $table->foreign('episode_id')
                ->references('id')->on('episode')
                ->onDelete('cascade');
            $table->index('episode', 'index_episode_n');
            $table->index('season', 'index_season_n');
        });

        Schema::create('mail_log', function ($table) {
            $table->increments('id');
            $table->string('type', 45);
            $table->text('content');
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
        Schema::drop('seen');
        Schema::drop('setting');
        Schema::drop('following');
        Schema::drop('user');
        Schema::drop('episode');
        Schema::drop('series');
    }
}
