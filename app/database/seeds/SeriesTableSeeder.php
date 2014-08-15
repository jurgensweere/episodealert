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
                'id' => 70327,
                'unique_name' => 'buffy_the_vampire_slayer',
                'name' => 'Buffy the Vampire Slayer',
                'description' => 'In every generation there is a Chosen One. She alone will stand against the vampires, the demons and the forces of darkness. She is the Slayer.
 
 Sarah Michelle Gellar stars as Buffy Summers, The Chosen One, the one girl in all the world with the strength...',
                'firstaired' => '1997-03-10',
                'rating' => '',
                'rating_updated' => '0000-00-00 00:00:00',
                'imdb_id' => 'tt0118276',
                'poster_image' => '70327.jpg',
                'poster_image_converted' => 1,
                'fanart_image' => '70327-28.jpg',
                'fanart_image_converted' => 1,
                'status' => 'Ended',
                'popular' => 0,
            )
        );

        $lost = Series::create(
            array(
                'id' => 73739,
                'unique_name' => 'lost',
                'name' => 'Lost',
                'description' => '4 8 15 16 23 42',
                'firstaired' => '1997-03-10',
                'rating' => '',
                'rating_updated' => '0000-00-00 00:00:00',
                'imdb_id' => 'tt0411008',
                'poster_image' => '73739.jpg',
                'poster_image_converted' => 1,
                'fanart_image' => '73739-4.jpg',
                'fanart_image_converted' => 1,
                'status' => 'Ended',
                'popular' => 0,
            )
        );

        $twentyfour = Series::create(
            array(
                'id' => 76290,
                'unique_name' => '24',
                'name' => '24',
                'description' => 'Jack Bauer longest day of his life.',
                'firstaired' => '1997-03-10',
                'rating' => '',
                'rating_updated' => '0000-00-00 00:00:00',
                'imdb_id' => 'tt0285331',
                'poster_image' => '76290.jpg',
                'poster_image_converted' => 1,
                'fanart_image' => '76290-1.jpg',
                'fanart_image_converted' => 1,
                'status' => 'Ended',
                'popular' => 0,
            )
        );

        $whitecollar = Series::create(
            array(
                'id' => 108611,
                'unique_name' => 'white_collar',
                'name' => 'White Collar',
                'description' => 'Longcat is long.',
                'firstaired' => '1997-03-10',
                'rating' => '',
                'rating_updated' => '0000-00-00 00:00:00',
                'imdb_id' => 'tt1358522',
                'poster_image' => '108611.jpg',
                'poster_image_converted' => 1,
                'fanart_image' => '108611-8.jpg',
                'fanart_image_converted' => 1,
                'status' => 'Ended',
                'popular' => 0,
            )
        );

        $walkingDead = Series::create(
            array(
                'id' => 153021,
                'unique_name' => 'the_walking_dead',
                'name' => 'The Walking Dead',
                'description' => 'Based on the comic book series of the same name, The Walking Dead tells the story of a small group of survivors living in the aftermath of a zombie apocalypse.',
                'firstaired' => '2010-10-31',
                'rating' => '',
                'rating_updated' => '0000-00-00 00:00:00',
                'imdb_id' => 'tt1520211',
                'poster_image' => '153021.jpg',
                'poster_image_converted' => 1,
                'fanart_image' => '153021-39.jpg',
                'fanart_image_converted' => 1,
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
