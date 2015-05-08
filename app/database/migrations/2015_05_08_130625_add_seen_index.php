<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeenIndex extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seen', function (Blueprint $table) {
            $table->index(['user_id','episode_id'], 'index_user_episode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seen', function (Blueprint $table) {
            $table->dropIndex('index_user_episode');
        });
    }
}
