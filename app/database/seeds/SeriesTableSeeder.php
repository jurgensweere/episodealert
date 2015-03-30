<?php

class SeriesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('series')->delete();
        
		\DB::table('series')->insert(array (
			0 => 
			array (
				'id' => 72449,
				'unique_name' => 'stargate_sg_1',
				'name' => 'Stargate SG-1',
			'description' => 'This sequel to the 1994 movie Stargate chronicles the further adventures of SGC (Stargate Command). It turned out that the Goa\'uld Ra was only one of many alien System Lords who used the Stargates to conquer much of the universe. When Earth uncovers a working cartouche to decipher the coding system of their own Stargate, they find they can now travel anywhere. Earth\'s military sends out SG teams to explore new planets, find technology, and oppose the Goa\'uld. Jack O\'Neill and Daniel Jackson from the original movie are part of SG-1. They are joined by Sam Carter, a scientist, and Teal\'c, a Jaffa who is convinced the Goa\'uld are not gods.',
				'firstaired' => '1997-07-01',
				'rating' => '9.3',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt0118480',
				'poster_image' => 'stargate_sg_1.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'stargate_sg_1.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'stargate_sg_1.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Adventure|Fantasy|Science-Fiction|',
				'status' => 'Ended',
				'popular' => 0,
				'trend' => 0,
				'season_amount' => 10,
				'episode_amount' => 214,
				'has_specials' => 1,
				'specials_amount' => 8,
				'created_at' => '2015-02-20 15:54:22',
				'updated_at' => '2015-02-20 15:54:35',
			),
			1 => 
			array (
				'id' => 78848,
				'unique_name' => 'puppets_who_kill',
				'name' => 'Puppets Who Kill',
				'description' => 'Puppets Who Kill is a live-action 30 minute comedy series.
The show is about a half-way house for very bad puppets.
Puppets who lie - Puppets who cheat - Puppets who have no 
respect for anything - Puppets who kill. The 13 episode series is centred around 4 felonious puppets who\'ve commited crimes and now live with their bumbling social worker Dan Barlow.  They live with him in hopes they can some day be re-integrated into society, although it won\'t be easy, they are conniving, bitter, self centered and dangerous... They are the anti - muppets.',
				'firstaired' => '2002-10-04',
				'rating' => '8.0',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => NULL,
				'poster_image' => 'puppets_who_kill.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'puppets_who_kill.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'puppets_who_kill.jpg',
				'banner_image_converted' => 1,
				'category' => '|Comedy|',
				'status' => 'Ended',
				'popular' => 0,
				'trend' => 0,
				'season_amount' => 5,
				'episode_amount' => 52,
				'has_specials' => 1,
				'specials_amount' => 3,
				'created_at' => '2015-02-20 16:38:47',
				'updated_at' => '2015-03-30 09:18:44',
			),
			2 => 
			array (
				'id' => 108611,
				'unique_name' => 'white_collar',
				'name' => 'White Collar',
				'description' => 'A white collar criminal agrees to help the FBI catch other white collar criminals using his expertise as an art and securities thief, counterfeiter, and conman.',
				'firstaired' => '2009-10-23',
				'rating' => '8.7',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt1358522',
				'poster_image' => 'white_collar.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'white_collar.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'white_collar.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Adventure|Crime|Drama|',
				'status' => 'Ended',
				'popular' => 0,
				'trend' => 1,
				'season_amount' => 6,
				'episode_amount' => 81,
				'has_specials' => 0,
				'specials_amount' => 0,
				'created_at' => '2015-02-20 17:05:36',
				'updated_at' => '2015-03-23 08:28:29',
			),
			3 => 
			array (
				'id' => 205281,
				'unique_name' => 'falling_skies',
				'name' => 'Falling Skies',
				'description' => 'The series tells the story of the aftermath of a global invasion by several races of extraterrestrials that neutralizes the world\'s power grid and technology, quickly destroys the combined militaries of all the world\'s countries, and apparently kills over 90% of the human population within a few days.',
				'firstaired' => '2011-06-19',
				'rating' => '7.9',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt1462059',
				'poster_image' => 'falling_skies.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'falling_skies.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'falling_skies.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Adventure|Science-Fiction|Thriller|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 1,
				'season_amount' => 5,
				'episode_amount' => 52,
				'has_specials' => 1,
				'specials_amount' => 3,
				'created_at' => '2015-02-20 16:59:09',
				'updated_at' => '2015-03-23 08:28:36',
			),
			4 => 
			array (
				'id' => 247808,
				'unique_name' => 'suits',
				'name' => 'Suits',
				'description' => 'Suits follows college drop-out Mike Ross, who accidentally lands a job with one of New York\'s best legal closers, Harvey Specter. They soon become a winning team with Mike\'s raw talent and photographic memory, and Mike soon reminds Harvey of why he went into the field of law in the first place.',
				'firstaired' => '2011-06-23',
				'rating' => '9.0',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt1632701',
				'poster_image' => 'suits.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'suits.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'suits.jpg',
				'banner_image_converted' => 1,
				'category' => '|Drama|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 0,
				'season_amount' => 4,
				'episode_amount' => 60,
				'has_specials' => 1,
				'specials_amount' => 24,
				'created_at' => '2015-02-20 15:54:55',
				'updated_at' => '2015-02-20 15:55:02',
			),
			5 => 
			array (
				'id' => 257655,
				'unique_name' => 'arrow',
				'name' => 'Arrow',
				'description' => 'Oliver Queen and his father are lost at sea when their luxury yacht sinks. His father doesn\'t survive. Oliver survives on an uncharted island for five years learning to fight, but also learning about his father\'s corruption and unscrupulous business dealings. He returns to civilization a changed man, determined to put things right. He disguises himself with the hood of one of his mysterious island mentors, arms himself with a bow and sets about hunting down the men and women who have corrupted his city.',
				'firstaired' => '2012-10-10',
				'rating' => '8.6',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt2193021',
				'poster_image' => 'arrow.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'arrow.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'arrow.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Adventure|Crime|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 1,
				'season_amount' => 3,
				'episode_amount' => 65,
				'has_specials' => 1,
				'specials_amount' => 7,
				'created_at' => '2015-02-20 17:02:29',
				'updated_at' => '2015-03-30 09:27:59',
			),
			6 => 
			array (
				'id' => 260449,
				'unique_name' => 'vikings',
				'name' => 'Vikings',
				'description' => 'Vikings follows the adventures of Ragnar Lothbrok the greatest hero of his age. The series tells the sagas of Ragnar\'s band of Viking brothers and his family, as he rises to become King of the Viking tribes. As well as being a fearless warrior, Ragnar embodies the Norse traditions of devotion to the gods, legend has it that he was a direct descendant of Odin, the god of war and warriors.',
				'firstaired' => '2013-03-03',
				'rating' => '9.1',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt2306299',
				'poster_image' => 'vikings.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'vikings.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'vikings.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Drama|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 1,
				'season_amount' => 3,
				'episode_amount' => 25,
				'has_specials' => 1,
				'specials_amount' => 1,
				'created_at' => '2015-02-20 17:08:00',
				'updated_at' => '2015-03-30 09:27:55',
			),
			7 => 
			array (
				'id' => 266189,
				'unique_name' => 'the_blacklist',
				'name' => 'The Blacklist',
				'description' => 'Raymond "Red" Reddington, one of the FBI\'s most wanted fugitives, surrenders in person at FBI Headquarters in Washington, D.C. He claims that he and the FBI have the same interests: bringing down dangerous criminals and terrorists. In the last two decades, he\'s made a list of criminals and terrorists that matter the most but the FBI cannot find because it does not know they exist. Reddington calls this "The Blacklist".
Reddington will co-operate, but insists that he will speak only to Elizabeth Keen, a rookie FBI profiler.',
				'firstaired' => '2013-09-23',
				'rating' => '8.4',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt2741602',
				'poster_image' => 'the_blacklist.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'the_blacklist.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'the_blacklist.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Crime|Drama|Mystery|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 1,
				'season_amount' => 2,
				'episode_amount' => 37,
				'has_specials' => 1,
				'specials_amount' => 2,
				'created_at' => '2015-02-20 17:08:29',
				'updated_at' => '2015-02-20 17:08:35',
			),
			8 => 
			array (
				'id' => 272128,
				'unique_name' => 'log_horizon',
				'name' => 'Log Horizon',
				'description' => 'The story begins when 30,000 Japanese gamers are trapped in the fantasy online game world Elder Tale. What was once a sword-and-sorcery world is now the real world. The main lead Shiroe attempts to survive with his old friend Naotsugu and the beautiful assassin Akatsuki.',
				'firstaired' => '2013-10-05',
				'rating' => '8.6',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt2942218',
				'poster_image' => 'log_horizon.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'log_horizon.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'log_horizon.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Adventure|Animation|Fantasy|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 0,
				'season_amount' => 2,
				'episode_amount' => 50,
				'has_specials' => 0,
				'specials_amount' => 0,
				'created_at' => '2015-02-20 15:44:52',
				'updated_at' => '2015-02-20 15:44:57',
			),
			9 => 
			array (
				'id' => 279121,
			'unique_name' => 'the_flash_(2014)',
			'name' => 'The Flash (2014)',
				'description' => 'After a particle accelerator causes a freak storm, CSI Investigator Barry Allen is struck by lightning and falls into a coma. Months later he awakens with the power of super speed, granting him the ability to move through Central City like an unseen guardian angel. Though initially excited by his newfound powers, Barry is shocked to discover he is not the only "meta-human" who was created in the wake of the accelerator explosion – and not everyone is using their new powers for good. Barry partners with S.T.A.R. Labs and dedicates his life to protect the innocent. For now, only a few close friends and associates know that Barry is literally the fastest man alive, but it won\'t be long before the world learns what Barry Allen has become... The Flash.',
				'firstaired' => '2014-10-07',
				'rating' => '8.5',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt3107288',
			'poster_image' => 'the_flash_(2014).jpg',
				'poster_image_converted' => 1,
			'fanart_image' => 'the_flash_(2014).jpg',
				'fanart_image_converted' => 1,
			'banner_image' => 'the_flash_(2014).jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Adventure|Drama|Science-Fiction|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 1,
				'season_amount' => 1,
				'episode_amount' => 18,
				'has_specials' => 0,
				'specials_amount' => 0,
				'created_at' => '2015-02-20 17:07:03',
				'updated_at' => '2015-03-23 08:28:31',
			),
			10 => 
			array (
				'id' => 281697,
				'unique_name' => 'stalker',
				'name' => 'Stalker',
				'description' => 'Det. Jack Larsen is a recent transfer to the Unit from New York City\'s homicide division, whose confidence, strong personality and questionable behavior has landed him in trouble before - but whose past behavior may also prove valuable in his new job. His boss, Lt. Beth Davis, is strong, focused and an expert in the field, driven by her traumatic personal experience as a victim. With the rest of their team, young but eager Det. Ben Caldwell and deceptively smart Det. Janice Lawrence, Larsen and Davis assess the threat level of cases and respond before the stalking and intimidation spirals out of control, all while trying to keep their personal obsessions at bay.',
				'firstaired' => '2014-10-01',
				'rating' => '7.9',
				'rating_updated' => '0000-00-00 00:00:00',
				'imdb_id' => 'tt3560094',
				'poster_image' => 'stalker.jpg',
				'poster_image_converted' => 1,
				'fanart_image' => 'stalker.jpg',
				'fanart_image_converted' => 1,
				'banner_image' => 'stalker.jpg',
				'banner_image_converted' => 1,
				'category' => '|Action|Crime|Drama|Thriller|',
				'status' => 'Continuing',
				'popular' => 0,
				'trend' => 1,
				'season_amount' => 1,
				'episode_amount' => 22,
				'has_specials' => 0,
				'specials_amount' => 0,
				'created_at' => '2015-02-20 16:55:35',
				'updated_at' => '2015-03-30 09:27:58',
			),
		));
	}

}
