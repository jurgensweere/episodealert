<?php namespace EA\models;

use Eloquent;

class Episode extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'episode';

    public function series()
    {
        return $this->belongsTo('EA\models\Series');
    }
}
