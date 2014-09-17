<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\Series;
use EA\models\Episode;
use EA\models\Following;
use EA\models\User;
use Auth;
use Log;

class SeriesController extends BaseController
{
    public function getSeries($uniqueName){
      return Response::json(Series::where('unique_name', $uniqueName)->first());
    }

    public function getByGenre($genre){
        return Response::json(Series::where('category', 'like', '%' . $genre . '%')->take(50)->get());
    }

    public function top()
    {
        // TODO: Make this select top (followed or trending?) series, instead of the first 5
        return Response::json(Series::take(5)->get());
    }

    public function search($query)
    {
        return Response::json(Series::where('name', 'like', '%' . $query . '%')->take(50)->get());
    }

	/*
	 * Get episodes of series by series->id
	 */
    public function getEpisodes($id){
        if(Auth::user()){
            $user_id = Auth::user()->id;

            $followingCheck = Following::where('series_id', $id)->where('user_id', $user_id)->count();
            
            if(!$followingCheck){
		          return self::getEpisodesFromGivenSeason($id, 1);
            } else {
                return self::getEpisodesFromLatestSeason($id);
            }
        }
        return self::getEpisodesFromGivenSeason($id, 1);
    }


    /*
     * Get episodes of series by series->id and from the latest season
     * Check if the serie is a following one, then find the season from the last seen episode and return all episodes from that season.
     * Else return episodes from season 1 by default
     */
    private function getEpisodesFromLatestSeason($id){
        Log::info("inside getEpisodesFromLatestSeason method ".$id);
        $lastSeason = Episode::where('series_id', $id )->select('season')->orderBy('season', 'desc')->first()->season;           
        return self::getEpisodesFromGivenSeason($id, $lastSeason);
    }

    private function getEpisodesFromGivenSeason($id, $season) {
       return Response::json(Episode::where('series_id', $id)->where('season', $season)->get());
    }

}
