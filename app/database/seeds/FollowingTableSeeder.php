<?php

class FollowingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('following')->delete();

        \DB::table('following')->insert(array (
            0 =>
            array (
                'id' => 1,
                'series_id' => 72449,
                'user_id' => 1,
                'archive' => 0,
                'last_notified' => null,
                'created_at' => '2015-03-05 19:57:42',
                'updated_at' => '2015-03-16 08:02:02',
            ),
            1 =>
            array (
                'id' => 2,
                'series_id' => 78848,
                'user_id' => 1,
                'archive' => 0,
                'last_notified' => null,
                'created_at' => '2015-03-05 19:57:42',
                'updated_at' => '2015-03-16 08:02:02',
            ),
            2 =>
            array (
                'id' => 3,
                'series_id' => 108611,
                'user_id' => 1,
                'archive' => 0,
                'last_notified' => null,
                'created_at' => '2015-03-05 19:57:42',
                'updated_at' => '2015-03-16 08:02:02',
            ),
            3 =>
            array (
                'id' => 4,
                'series_id' => 205281,
                'user_id' => 1,
                'archive' => 0,
                'last_notified' => null,
                'created_at' => '2015-03-05 19:57:42',
                'updated_at' => '2015-03-16 08:02:02',
            ),
            4 =>
            array (
                'id' => 5,
                'series_id' => 247808,
                'user_id' => 1,
                'archive' => 0,
                'last_notified' => null,
                'created_at' => '2015-03-05 19:57:42',
                'updated_at' => '2015-03-16 08:02:02',
            ),
            5 =>
            array (
                'id' => 6,
                'series_id' => 257655,
                'user_id' => 1,
                'archive' => 0,
                'last_notified' => null,
                'created_at' => '2015-03-05 19:57:42',
                'updated_at' => '2015-03-16 08:02:02',
            ),
        ));
    }
}
