<?php

use EA\models\Series;
use EA\models\Episode;

class SeriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('episode')->delete();
        DB::table('series')->delete();

        // Insert new seeds
    }
}
