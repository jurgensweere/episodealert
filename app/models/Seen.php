<?php namespace EA\models;

use Eloquent;

class Seen extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seen';


    const MODE_SINGLE = 'single';
    const MODE_UNTIL = 'until';
    const MODE_SEASON = 'season';
}
