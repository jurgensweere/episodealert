<?php namespace EA\models;

use Eloquent;
use Carbon\Carbon;
use Auth;

class Episode extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'episode';

    // appends following to the model when its created, very fancy
    protected $appends = array('seen');

    public function getAirdateAttribute($value){
    	return Carbon::parse($value)->format('d-m-Y');
    }

    /*
     * If user is authorized check if the episode is seen, otherwise return 0
     */
    public function getSeenAttribute(){
        if(Auth::user()){
            return count(Seen::where('episode_id' , $this->id)->where('user_id', Auth::user()->id)->get());
        }else{
            return false;
        }
    }

    public function series()
    {
        return $this->belongsTo('EA\models\Series');
    }
}
