<?php namespace EA\models;

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
        return $this->belongsTo('Series');
    }
}
