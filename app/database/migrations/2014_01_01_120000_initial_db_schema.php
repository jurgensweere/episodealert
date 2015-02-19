<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialDbSchema extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE TABLE IF NOT EXISTS `episodes` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `tvdb_id` int(10) unsigned NOT NULL,
          `tvserie_id` int(10) unsigned NOT NULL,
          `season` int(10) unsigned NOT NULL,
          `episode` int(10) unsigned NOT NULL,
          `airdate` date DEFAULT NULL,
          `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT \'untitled\',
          `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
          PRIMARY KEY (`id`),
          KEY `tvdb_id` (`tvdb_id`),
          KEY `airdate` (`airdate`),
          KEY `tvserie_id` (`tvserie_id`),
          KEY `season` (`season`),
          KEY `episode` (`episode`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

        DB::statement('CREATE TABLE IF NOT EXISTS `following` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `series_id` int(10) unsigned NOT NULL,
          `user_id` int(10) unsigned NOT NULL,
          `archive` tinyint(4) NOT NULL DEFAULT \'0\',
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

        DB::statement('CREATE TABLE IF NOT EXISTS `mail_log` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `type` varchar(45) NOT NULL,
          `content` text,
          `recipient` varchar(45) NOT NULL,
          `status` tinyint(4) NOT NULL,
          `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

        DB::statement('CREATE TABLE IF NOT EXISTS `mail_users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `processed` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

        DB::statement('CREATE TABLE IF NOT EXISTS `seen` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(10) unsigned NOT NULL,
          `serie_id` int(10) unsigned NOT NULL,
          `episode_id` int(10) unsigned NOT NULL,
          `season` int(10) unsigned NOT NULL,
          `episode` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_user_id` (`user_id`),
          KEY `fk_serie_id` (`serie_id`),
          KEY `season_id` (`season`),
          KEY `fk_episode_id` (`episode`),
          KEY `episode_id` (`episode_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

        DB::statement('CREATE TABLE IF NOT EXISTS `series` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `tvdb_id` int(10) unsigned NOT NULL,
          `unique_name` varchar(100) NOT NULL,
          `name` varchar(100) NOT NULL DEFAULT \'untitled\',
          `description` text NOT NULL,
          `status` varchar(25) DEFAULT NULL,
          `firstaired` date DEFAULT NULL,
          `rating` varchar(10) DEFAULT NULL,
          `rating_updated` date DEFAULT NULL,
          `popular` tinyint(1) NOT NULL DEFAULT \'0\',
          `imdb_id` varchar(10) DEFAULT NULL,
          `image` tinyint(1) NOT NULL DEFAULT \'0\',
          `imageconverted` tinyint(1) NOT NULL DEFAULT \'0\',
          `last_updated` datetime DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `tvdb_id` (`tvdb_id`),
          KEY `unique_name` (`unique_name`),
          KEY `name` (`name`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

        DB::statement('CREATE TABLE IF NOT EXISTS `settings` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `tvdb_last_updated` datetime DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

        DB::statement('CREATE TABLE IF NOT EXISTS `update_queue` (
          `tvdb_serieid` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `added` datetime DEFAULT NULL,
          `processed` datetime DEFAULT NULL,
          `retries` int(11) NOT NULL DEFAULT \'0\',
          PRIMARY KEY (`tvdb_serieid`)
        ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

        DB::statement('CREATE TABLE IF NOT EXISTS `users` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `accountname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT \'\',
          `password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
          `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
          `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
          `registered` tinyint(1) NOT NULL DEFAULT \'0\',
          `publicfollow` tinyint(4) NOT NULL DEFAULT \'0\',
          `showonlyrunning` tinyint(1) NOT NULL DEFAULT \'0\',
          `registrationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `lastlogin` datetime DEFAULT NULL,
          `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT \'member\',
          `receivealerts` tinyint(1) NOT NULL DEFAULT \'1\',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
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
