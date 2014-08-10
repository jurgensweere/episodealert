<?php

use EA\models\Series;
use EA\models\Episode;

class SeriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('episode')->delete();
        DB::table('series')->delete();

        $buffy = Series::create(
            array(
                'unique_name' => 'buffy_the_vampire_slayer',
                'name' => 'Buffy the Vampire Slayer',
                'description' => 'In every generation there is a Chosen One. She alone will stand against the vampires, the demons and the forces of darkness. She is the Slayer.
 
 Sarah Michelle Gellar stars as Buffy Summers, The Chosen One, the one girl in all the world with the strength...',
                'firstaired' => '1997-03-10',
                'rating' => '',
                'rating_updated' => '0000-00-00 00:00:00',
                'imdb_id' => 'tt0118276',
                'image' => '',
                'imageconverted' => 0,
                'status' => 'Ended',
                'popular' => 0,
            )
        );

        $walkingDead = Series::create(
            array(
                'unique_name' => 'the_walking_dead',
                'name' => 'The Walking Dead',
                'description' => 'Based on the comic book series of the same name, The Walking Dead tells the story of a small group of survivors living in the aftermath of a zombie apocalypse.',
                'firstaired' => '2010-10-31',
                'rating' => '',
                'rating_updated' => '0000-00-00 00:00:00',
                'imdb_id' => 'tt1520211',
                'image' => '',
                'imageconverted' => 0,
                'status' => 'Continuing',
                'popular' => 0,
            )
        );

        $buffyEpisodes = array(
            new Episode(array('season' => 1, 'episode' => 1, 'airdate' => '1997-03-10', 'name' => 'Episode 1', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 2, 'airdate' => '1997-03-11', 'name' => 'Episode 2', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 3, 'airdate' => '1997-03-12', 'name' => 'Episode 3', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 4, 'airdate' => '1997-03-13', 'name' => 'Episode 4', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 5, 'airdate' => '1997-03-14', 'name' => 'Episode 5', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 6, 'airdate' => '1997-03-15', 'name' => 'Episode 6', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 1, 'airdate' => '1998-03-10', 'name' => 'Episode 1', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 2, 'airdate' => '1998-03-11', 'name' => 'Episode 2', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 3, 'airdate' => '1998-03-12', 'name' => 'Episode 3', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 4, 'airdate' => '1998-03-13', 'name' => 'Episode 4', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 5, 'airdate' => '1998-03-14', 'name' => 'Episode 5', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 6, 'airdate' => '1998-03-15', 'name' => 'Episode 6', 'description' => 'desc')),
        );

        $buffy->episodes()->saveMany($buffyEpisodes);

        $walkingDeadEpisodes = array(
            new Episode(array('season' => 1, 'episode' => 1, 'airdate' => '1997-03-10', 'name' => 'Episode 1', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 2, 'airdate' => '1997-03-11', 'name' => 'Episode 2', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 3, 'airdate' => '1997-03-12', 'name' => 'Episode 3', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 4, 'airdate' => '1997-03-13', 'name' => 'Episode 4', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 5, 'airdate' => '1997-03-14', 'name' => 'Episode 5', 'description' => 'desc')),
            new Episode(array('season' => 1, 'episode' => 6, 'airdate' => '1997-03-15', 'name' => 'Episode 6', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 1, 'airdate' => '1998-03-10', 'name' => 'Episode 1', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 2, 'airdate' => '1998-03-11', 'name' => 'Episode 2', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 3, 'airdate' => '1998-03-12', 'name' => 'Episode 3', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 4, 'airdate' => '1998-03-13', 'name' => 'Episode 4', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 5, 'airdate' => '1998-03-14', 'name' => 'Episode 5', 'description' => 'desc')),
            new Episode(array('season' => 2, 'episode' => 6, 'airdate' => '1998-03-15', 'name' => 'Episode 6', 'description' => 'desc')),
        );

        $walkingDead->episodes()->saveMany($walkingDeadEpisodes);
    }
}
