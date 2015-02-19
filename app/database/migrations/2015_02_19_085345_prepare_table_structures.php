<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrepareTableStructures extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rename tables
        DB::statement('RENAME TABLE  `episodes` TO `episode`');
        DB::statement('RENAME TABLE  `settings` TO `setting`');
        DB::statement('RENAME TABLE  `users` TO `user`');

        // Modify episode
        DB::statement('ALTER TABLE `episode` ADD series_id int(10) unsigned NOT NULL AFTER `id`;'); // The new series ID (tvdb_id)
        DB::statement('ALTER TABLE `episode` CHANGE `season` `season` int(11) NOT NULL;');
        DB::statement('ALTER TABLE `episode` CHANGE `episode` `episode` int(11) NOT NULL;');
        DB::statement('ALTER TABLE `episode` CHANGE `airdate` `airdate` datetime DEFAULT NULL;');
        DB::statement('ALTER TABLE `episode` ADD image varchar(255) COLLATE utf8_unicode_ci NOT NULL AFTER `description`;');
        DB::statement('ALTER TABLE `episode` ADD created_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `image`;');
        DB::statement('ALTER TABLE `episode` ADD updated_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `created_at`;');
        DB::statement('ALTER TABLE `episode` CONVERT TO CHARACTER SET utf8 collate utf8_unicode_ci;');

        // Modify following
        DB::statement('ALTER TABLE `following` CHANGE `series_id` `tvserie_id` int(10) unsigned NOT NULL;');
        DB::statement('ALTER TABLE `following` ADD series_id int(10) unsigned NOT NULL AFTER `id`;'); // The new series ID (tvdb_id)
        DB::statement('ALTER TABLE `following` CHANGE `archive` `archive` tinyint(1) NOT NULL DEFAULT \'0\';');
        DB::statement('ALTER TABLE `following` ADD last_notified date DEFAULT NULL AFTER `archive`;');
        DB::statement('ALTER TABLE `following` ADD created_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `last_notified`;');
        DB::statement('ALTER TABLE `following` ADD updated_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `created_at`;');
        DB::statement('ALTER TABLE `following` CONVERT TO CHARACTER SET utf8 collate utf8_unicode_ci;');

        // Modify mail_log
        DB::statement('ALTER TABLE `mail_log` CHANGE `recipient` `recipient` varchar(150) NOT NULL;');
        DB::statement('ALTER TABLE `mail_log` CHANGE `status` `status` tinyint(1) NOT NULL;');
        DB::statement('ALTER TABLE `mail_log` CHANGE `timestamp` `created_at` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\';');
        DB::statement('ALTER TABLE `mail_log` ADD updated_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `created_at`;');
        DB::statement('ALTER TABLE `mail_log` CONVERT TO CHARACTER SET utf8 collate utf8_unicode_ci;');
        DB::statement('UPDATE `mail_log` SET updated_at = created_at;');

        // Modify seen
        DB::statement('ALTER TABLE `seen` CHANGE `serie_id` `tvserie_id` int(10) unsigned NOT NULL;');
        DB::statement('ALTER TABLE `seen` CHANGE `episode_id` `oldepisode_id` int(10) unsigned NOT NULL;');
        DB::statement('ALTER TABLE `seen` CHANGE `season` `season` int(11) NOT NULL;');
        DB::statement('ALTER TABLE `seen` CHANGE `episode` `episode` int(11) NOT NULL;');
        DB::statement('ALTER TABLE `seen` ADD series_id int(10) unsigned NOT NULL AFTER `user_id`;');
        DB::statement('ALTER TABLE `seen` ADD episode_id int(10) unsigned NOT NULL AFTER `series_id`;');
        DB::statement('ALTER TABLE `seen` ADD created_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `episode`;');
        DB::statement('ALTER TABLE `seen` ADD updated_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `created_at`;');
        DB::statement('ALTER TABLE `seen` CONVERT TO CHARACTER SET utf8 collate utf8_unicode_ci;');

        // Modify series
        DB::statement('ALTER TABLE `series` CONVERT TO CHARACTER SET utf8 collate utf8_unicode_ci;');
        DB::statement('ALTER TABLE `series` CHANGE `rating_updated` `rating_updated` datetime NOT NULL;');
        DB::statement('ALTER TABLE `series` DROP COLUMN `image`;');
        DB::statement('ALTER TABLE `series` DROP COLUMN `imageconverted`;');
        DB::statement('ALTER TABLE `series` ADD `poster_image` varchar(128) DEFAULT NULL AFTER `imdb_id`;');
        DB::statement('ALTER TABLE `series` ADD `poster_image_converted` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `poster_image`;');
        DB::statement('ALTER TABLE `series` ADD `fanart_image` varchar(128) DEFAULT NULL AFTER `poster_image_converted`;');
        DB::statement('ALTER TABLE `series` ADD `fanart_image_converted` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `fanart_image`;');
        DB::statement('ALTER TABLE `series` ADD `banner_image` varchar(128) DEFAULT NULL AFTER `fanart_image_converted`;');
        DB::statement('ALTER TABLE `series` ADD `banner_image_converted` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `banner_image`;');
        DB::statement('ALTER TABLE `series` ADD `category` varchar(128) NOT NULL AFTER `banner_image_converted`;');
        DB::statement('ALTER TABLE `series` CHANGE `status` `status` varchar(25) DEFAULT NULL AFTER `category`;');
        DB::statement('ALTER TABLE `series` CHANGE `popular` `popular` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `status`;');
        DB::statement('ALTER TABLE `series` ADD `season_amount` int(10) unsigned DEFAULT NULL AFTER `popular`;');
        DB::statement('ALTER TABLE `series` ADD `episode_amount` int(10) unsigned DEFAULT NULL AFTER `season_amount`;');
        DB::statement('ALTER TABLE `series` ADD `has_specials` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `episode_amount`;');
        DB::statement('ALTER TABLE `series` ADD `specials_amount` int(10) unsigned NOT NULL DEFAULT \'0\' AFTER `has_specials`;');
        DB::statement('ALTER TABLE `series` CHANGE `last_updated` `created_at` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `specials_amount`;');
        DB::statement('ALTER TABLE `series` ADD updated_at timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `created_at`;');
        DB::statement('UPDATE `series` SET updated_at = created_at;');

        // Modify settings
        DB::statement('ALTER TABLE `setting` ADD `key` varchar(32) NOT NULL AFTER `id`;');
        DB::statement('ALTER TABLE `setting` CHANGE `tvdb_last_updated` `value` varchar(128) NOT NULL;');
        DB::statement('UPDATE `setting` SET `key` = \'lastUpdateTime\';');
        DB::statement('UPDATE `setting` SET `value` = UNIX_TIMESTAMP(value);');

        // Modify user
        DB::statement('ALTER TABLE `user` CONVERT TO CHARACTER SET utf8 collate utf8_unicode_ci;');
        DB::statement('ALTER TABLE `user` CHANGE `accountname` `old_accountname` varchar(100) NOT NULL;');
        DB::statement('ALTER TABLE `user` ADD `accountname` varchar(200) NOT NULL AFTER `old_accountname`;');
        DB::statement('ALTER TABLE `user` ADD `oauthprovider` enum(\'google\',\'facebook\') DEFAULT NULL AFTER `accountname`;');
        DB::statement('ALTER TABLE `user` ADD `oauthid` varchar(100) DEFAULT NULL AFTER `oauthprovider`;');
        DB::statement('ALTER TABLE `user` CHANGE `password` `old_password` varchar(32) NOT NULL;');
        DB::statement('ALTER TABLE `user` ADD `password` varchar(256) DEFAULT NULL AFTER `old_password`;');
        DB::statement('ALTER TABLE `user` CHANGE `username` `old_username` varchar(100) DEFAULT NULL;');
        DB::statement('ALTER TABLE `user` ADD `username` varchar(100) NOT NULL AFTER `old_username`;');
        DB::statement('ALTER TABLE `user` CHANGE `email` `email` varchar(150) NOT NULL;');
        DB::statement('ALTER TABLE `user` ADD `following` int(11) NOT NULL DEFAULT \'0\' AFTER `registered`;');
        DB::statement('ALTER TABLE `user` CHANGE `publicfollow` `publicfollow` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `following`;');
        DB::statement('ALTER TABLE `user` CHANGE `receivealerts` `alerts` tinyint(1) NOT NULL DEFAULT \'1\' AFTER `publicfollow`;');
        DB::statement('ALTER TABLE `user` CHANGE `role` `role` varchar(10) NOT NULL DEFAULT \'member\' AFTER `showonlyrunning`;');
        DB::statement('ALTER TABLE `user` CHANGE `registrationdate` `created_at` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `role`;');
        DB::statement('ALTER TABLE `user` CHANGE `lastlogin` `updated_at` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `created_at`;');
        DB::statement('ALTER TABLE `user` ADD `remember_token` varchar(100) DEFAULT NULL AFTER `updated_at`;');
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
