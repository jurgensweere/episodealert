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

    /**
     * Indicates which fields should be returned as booleans.
     *
     * @var array
     */
    public $booleans = array('poster_image_converted', 'fanart_image_converted', 'banner_image_converted', 'popular', 'has_specials');

    // appends following to the model when its created, very fancy
    protected $appends = array('following');

    public function episodes()
    {
        return $this->hasMany('EA\models\Episode');
    }

    /*
     * If user is authorized check if the series is followed, otherwise return 0
     */
    public function getFollowingAttribute()
    {
        if (Auth::user()) {
            return count(Following::where('series_id', $this->id)->where('user_id', Auth::user()->id)->get());
        } else {
            return false;
        }
    }

    /**
     * Creates a unique name for this series and assigns to object.
     *
     * @param int|null $duplicateCounter
     */
    public function assignUniqueName($duplicateCounter = null)
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

        // Cycle through postfixes to avoid duplicate names.
        if ($duplicateCounter !== null) {
            $name .= "_($year)";

            if ($duplicateCounter > 0) {
                $name .= '_' . $duplicateCounter;
            }
        }

        $black_list = array("browse");
        if (in_array($name, $black_list)) {
            $name .= "_($year)";
        }
        $duplicate = Series::whereUniqueName($name)->first();

        if ($duplicate && $duplicate->id != $this->id) {
            return $this->assignUniqueName($duplicateCounter + 1);
        } else {
            $this->unique_name = $name;
            return $this;
        }
    }

    public function getPosterLocation()
    {
        return "public/img/poster/" . $this->getImageShortHand() . "/";
    }

    public function getBannerLocation()
    {
        return "public/img/banner/" . $this->getImageShortHand() . "/";
    }

    public function getFanartLocation()
    {
        return "public/img/fanart/" . $this->getImageShortHand() . "/";
    }

    public function getImageShortHand()
    {
        return substr($this->unique_name, 0, 2);
    }
}
