<?php namespace EA\models;

use Eloquent;
use Log;
use EA\models\Following;
use Auth;

class Series extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'series';

    // appends following to the model when its created, very fancy
    protected $appends = array('following');

    public function episodes()
    {
        return $this->hasMany('EA\models\Episode');
    }

    /*
     * If user is authorized check if the series is followed, otherwise return 0
     */
    public function getFollowingAttribute(){
    	if(Auth::user()){
    		return count(Following::where('series_id' , $this->id)->where('user_id', Auth::user()->id)->get());
    	}else{
    		return false;
    	}
    }

    /**
     * Creates a unique name for this series and assigns to object.
     *
     * @param <type> $postfix
     */
    public function assignUniqueName($postfix = '')
    {
        $name = $this->name;
        if (strlen($name) == 0) {
            return;
        }
        $name = strtolower($name);

        list ($year,$month,$day) = explode("-", !empty($this->firstaired) ? $this->firstaired : '--');

        $chars = array(
            "é" => "e",
            "è" => "e",
            "ê" => "e",
            "ë" => "e",
            "à" => "a",
            "á" => "a",
            "â" => "a",
            "ä" => "a",
            "ì" => "i",
            "í" => "i",
            "î" => "i",
            "ï" => "i",
            "ò" => "o",
            "ó" => "o",
            "ô" => "o");
        $name = str_replace(array_keys($chars), $chars, $name);

        $name = preg_replace("/[^a-zA-Z0-9\(\)]{1}/", "_", $name);
        $name = preg_replace("/[\_]+$/", "", $name);
        $name = preg_replace("/^[\_]+/", "", $name);
        $name = preg_replace("/[\_]+/", "_", $name);

        $name .= $postfix;

        $black_list = array("browse");
        if (in_array($name, $black_list)) {
            $name .= "_($year)";
        }
        $duplicate = Series::whereUniqueName($name)->first();

        if ($duplicate && $duplicate->id != $this->id) {
            if ($postfix == "_($year)") {
                $postfix .= '_1';
            } else {
                $postfix = "_($year)";
            }
            return $this->assignUniqueName($postfix);
        } else {
            $this->unique_name = $name;
            return $this;
        }
    }
}
