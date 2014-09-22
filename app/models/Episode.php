<?php namespace EA\models;

use Eloquent;
use Carbon\Carbon;

class Episode extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'episode';

    public function getAirdateAttribute($value){
    	return Carbon::parse($value)->format('d-m-Y');
    }

    public function series()
    {
        return $this->belongsTo('EA\models\Series');
    }
}
