<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `episode` ADD CONSTRAINT episode_series_id_foreign FOREIGN KEY (series_id) references series(id) ON DELETE CASCADE;');
        
        // There are some following records that have no user record. Delete those
        DB::statement('delete following from following left join user u on u.id = following.user_id where u.id is null;');
        DB::statement('ALTER TABLE `following` ADD CONSTRAINT `following_series_id_foreign` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE,
                                                   CONSTRAINT `following_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;');
        
        // There are some seen records that have no episodes
        DB::statement('delete seen from seen left join episode e on e.id = seen.episode_id where e.id is null;');
        DB::statement('delete seen from seen left join series s on s.id = seen.series_id where s.id is null;');
        DB::statement('delete seen from seen left join user u on u.id = seen.user_id where u.id is null;');
        DB::statement('ALTER TABLE `seen` ADD CONSTRAINT `seen_episode_id_foreign` FOREIGN KEY (`episode_id`) REFERENCES `episode` (`id`) ON DELETE CASCADE,
                                              CONSTRAINT `seen_series_id_foreign` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE,
                                              CONSTRAINT `seen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;');
        DB::statement('ALTER TABLE `seen` ADD INDEX `index_episode_n` (`episode`);');
        DB::statement('ALTER TABLE `seen` ADD INDEX `index_season_n` (`season`);');

        DB::statement('ALTER TABLE `series` ADD INDEX `multi_index` (`imdb_id`,`status`);');
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
