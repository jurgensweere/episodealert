<?php namespace EA;

use Config;
use File;
use Log;

class Tvdb
{
    /*
     * thetvdb.com settings
     */
    private $api_key;
    private $lang;
    private $tvdbapiurl;
    public $posterPath;
    public $episodeImagePath;

    /*
     * constructor
     * Initializes the class
     */
    public function __construct($apikey = null)
    {
        if (isset($apikey)) {
            $this->api_key = $apikey;
        } else {
            $this->api_key = Config::get('app.tvdb.key', '');
        }
        $this->lang = Config::get('app.tvdb.lang', 'en');
        $this->tvdbapiurl = Config::get('app.tvdb.url', 'http://www.thetvdb.com/api/');
        $this->posterPath = Config::get('app.tvdb.posterpath', 'http://thetvdb.com/banners/');
        $this->episodeImagePath = Config::get('app.tvdb.episodeimagepath', 'http://thetvdb.com/banners/');
    }

    public function getSeriesUpdates($timestamp)
    {
        $timestamp = urlencode($timestamp);
        $url = $this->tvdbapiurl . 'Updates.php?type=series&time=' . $timestamp;

        $feed = self::downloadUrl($url, 5);
        $xml = simplexml_load_string($feed);

        return $xml;
    }

    public function getUpdates($timestamp)
    {
        $timestamp = urlencode($timestamp);
        $url = $this->tvdbapiurl . 'Updates.php?type=all&time=' . $timestamp;

        $feed = self::downloadUrl($url);
        $xml = simplexml_load_string($feed);

        return $xml;
    }

    public function findSeries($seriename)
    {
        $seriename = urlencode($seriename);
        $url = $this->tvdbapiurl . 'GetSeries.php?seriesname=' . $seriename;

        $feed = self::downloadUrl($url);

        if ($feed) {
            $xml = simplexml_load_string($feed);

            $node = $xml->Series;

            $result = array();
            foreach ($node as $series) {
                $s = new Default_Model_Series();
                $s->setName($series->SeriesName);
                isset($series->Overview) ? $s->setDescription($series->Overview) : $s->setDescription('');
                $s->setTVDBId($series->seriesid);
                if (isset($series->IMDB_ID)) {
                    $s->setIMDBId($series->IMDB_ID);
                }
                if (isset($series->FirstAired)) {
                    $s->setFirstAired($series->FirstAired);
                }
                $result[] = $s;
            }

            return $result;
        } else {
            return false;
        }
    }

    /*
     * This method returns the serie id for the given seriename
     */
    public function getSeriesId($seriename)
    {
        $seriename = urlencode($seriename);
        $url = $this->tvdbapiurl . 'GetSeries.php?seriesname=' . $seriename;

        $feed = self::downloadUrl($url);
        $xml = simplexml_load_string($feed);

        $node = $xml->Series->seriesid;

        if ($node !== null) {
            $serieid = (int) $node;

            return $serieid;
        } else {
            return false;
        }
    }

    /*
     * This method returns the episode id for the
     * given serieid and season/episode number
     */
    public function getEpisodeId($serieid, $s, $e)
    {
        $url = $this->tvdbapiurl . $this->api_key . '/series/' . $serieid . '/default/' . $s . '/' . $e . '/' . $this->lang. '.xml';

        $feed = self::downloadUrl($url);
        $xml = simplexml_load_string($feed);

        $node = $xml->Episode->id;

        if ($node !== null) {
            $episodeid = (int) $node;

            return $episodeid;
        } else {
            return false;
        }
    }

    public function getPosterImage($series, $poster){
        //create poster url

        $posterUrl = $this->posterPath.$poster;

        $posterSubDirectory = substr($series['unique_name'], 0,2);

        //self::downloadUrl($posterUrl);
        //download image
        $ch = curl_init($posterUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);

        if (!file_exists("public/img/poster/".$posterSubDirectory."/")) {
            mkdir("public/img/poster/".$posterSubDirectory."/", 0777, true);
        }

        $fp = fopen("public/img/poster/".$posterSubDirectory."/".$series['unique_name'].".jpg",'w');
        fwrite($fp, $rawdata);
        
        return fclose($fp);

        //resize image
        //Save images in different locations for Lost example 
        //goes to /poster/images/lo/lost
    }

    public function getEpisodeImage($serieid, $s, $e)
    {
        $url = $this->tvdbapiurl . $this->api_key . '/series/' . $serieid . '/default/' . $s . '/' . $e . '/' . $this->lang. '.xml';
        $feed = self::downloadUrl($url);
        $xml = simplexml_load_string($feed);

        $node = $xml->Episode->filename;

        if ($node !== null) {
            $episodeimage = (string) $node;

            return $episodeimage;
        } else {
            return false;
        }
    }

    /*
     * This method returns information about the specified serie
     */
    public function getSerieData($serieid, $getepisodes = false)
    {
    // get feed
        if ($getepisodes === true) {
            if (function_exists('zip_open')) {
                $url = $this->tvdbapiurl . $this->api_key. '/series/' . $serieid . '/all/' .$this->lang. '.zip';
            } else {
                $url = $this->tvdbapiurl . $this->api_key. '/series/' . $serieid . '/all/' .$this->lang. '.xml';
            }
        } else {
            $url = $this->tvdbapiurl . $this->api_key. '/series/' . $serieid . '/' .$this->lang. '.xml';
        }

        $feed = self::downloadUrl($url);

        if ($feed) {
            $xml = simplexml_load_string($feed);

            $serie['id'] = $serieid;
            $serie['name'] = (string) $xml->Series->SeriesName;
            $serie['description'] = isset($xml->Series->Overview) ? (string) $xml->Series->Overview : '';
            $serie['imdb_id'] = isset($xml->Series->IMDB_ID) ? (string) $xml->Series->IMDB_ID : '';
            $serie['firstaired'] = (string) $xml->Series->FirstAired;
            $serie['lastupdated'] = (int) $xml->Series->lastupdated;
            $serie['poster'] = isset($xml->Series->poster) ? (string) $xml->Series->poster : null;
            $serie['status'] = isset($xml->Series->Status) ? (string) $xml->Series->Status : null;
            $serie['rating'] = isset($xml->Series->Rating) ? (string) $xml->Series->Rating : null;
            $serie['category'] = isset($xml->Series->Genre) ? (string) $xml->Series->Genre : null;

            if ($getepisodes === true) {
                $episodes = array();
                foreach ($xml->Episode as $ep) {
                    $episode['id'] = (int) $ep->id;
                    $episode['season'] = (int) $ep->SeasonNumber;
                    $episode['episode'] = (int) $ep->EpisodeNumber;
                    $episode['airdate'] = (string) $ep->FirstAired;
                    $episode['name'] = (string) $ep->EpisodeName;
                    $episode['description'] = (string) $ep->Overview;
                    $episodes[] = $episode;
                }
                $serie['episodes'] = $episodes;
            }

            return $serie;
        } else {
            return false;
        }
    }

    /*
     * This method returns information about the specified episode
     */
    public function getEpisodeData($episodeid)
    {
    // get feed
        $url = $this->tvdbapiurl .$this->api_key. '/episodes/' . $episodeid . '/' .$this->lang. '.xml';

        $feed = self::downloadUrl($url);
        if ($feed) {
            $xml = simplexml_load_string($feed);

            $episode['id'] = $episodeid;
            $episode['serieid'] = (int) $xml->Episode->seriesid;
            $episode['season'] = (int) $xml->Episode->SeasonNumber;
            $episode['episode'] = (int) $xml->Episode->EpisodeNumber;
            $episode['airdate'] = (string) $xml->Episode->FirstAired;
            $episode['name'] = (string) $xml->Episode->EpisodeName;
            $episode['description'] = (string) $xml->Episode->Overview;

            return $episode;
        } else {
            return false;
        }
    }

    /*
     * This method downloads a file by an url,
     * if the download fails it will retry, until the number of
     * retrys specified is reached. When the last try fails the
     * method will return false.
     */
    private static function downloadUrl($url, $timeout = 3)
    {
        $ch = curl_init();
        $data = '';

        if (substr($url, -3) == 'zip') {
            $temp_dir  = storage_path('tmp/' . self::getUniqueCode() . '/');
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }
            $temp_dir = realpath($temp_dir);
            $temp_file = $temp_dir . '/data.zip';

            $fp = fopen($temp_file, 'w+');//This is the file where we save the information
            $ch = curl_init($url);//Here is the file we are downloading
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            // PHP Bug
            if (is_resource($fp)) {
                fclose($fp);
            }

            $temp_file = realpath($temp_file);

            $zip = zip_open($temp_file);
            if (is_resource($zip)) {
                while ($zip_entry = zip_read($zip)) {
                    $fp = fopen($temp_dir. "/" .zip_entry_name($zip_entry), "w");
                    if (zip_entry_open($zip, $zip_entry, "r")) {
                        $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                        fwrite($fp, "$buf");
                        zip_entry_close($zip_entry);
                        fclose($fp);
                    }
                }
                zip_close($zip);
            }
            if (is_file($temp_dir . '/en.xml')) {
                $data = file_get_contents($temp_dir . '/en.xml');
            }
            File::deleteDirectory($temp_dir);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // times out after 4s
            //Dit lost problemen op voor episodes, maar waarom weet ik niet. Gzip lijkt wel default in de header te staan
            //Waar curl niet niet herkende en me de gecodeerde content gaf
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
            $data = curl_exec($ch);

        }

        return $data;
    }

    private static function getUniqueCode($length = "")
    {
        $code = md5(uniqid(rand(), true));
        if ($length != "") {
            return substr($code, 0, $length);
        } else {
            return $code;
        }
    }

    public function isEmptySeries($data)
    {
        if ($data['name'] == '') {
            Log::info("This serie has no name : ". $data['id'] . " d:" .$data['description'] . " imdb:" . $data['imdb_id']);

            return true;
        }

        return false;
    }
}
