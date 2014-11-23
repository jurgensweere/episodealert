<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\Series;
use EA\models\Episode;
use EA\models\Following;
use EA\models\User;
use EA\models\Seen;
use Auth;
use Log;
use Input;

class SeriesController extends BaseController
{
    public function getSeries($uniqueName){
	  $series = Series::where('unique_name', $uniqueName)->first();
	 // $series->following = $series->isFollowing();

      return Response::json( $series );
    }

    public function getByGenre($genre){
        return Response::json(Series::where('category', 'like', '%' . $genre . '%')->take(50)->get());
    }

    public function top()
    {
        // TODO: Make this select top (followed or trending?) series, instead of the first 5
        return Response::json(Series::whereNotNull('fanart_image')->take(5)->get());
    }

    public function search($query)
    {
        return Response::json(Series::where('name', 'like', '%' . $query . '%')->take(50)->get());
    }

    public function getEpisodesBySeason($series_id, $season){
    	return Response::json(Episode::where('series_id', $series_id)->where('season', $season)->get());
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

    /*
     * Seen code
     */

    public function setSeenEpisode(){
        if(Auth::user()){

            $user_id = Auth::user()->id;
            $episode_id = Input::get('episode_id');
            $episode_season = Input::get('episode_season');
            $episode_number = Input::get('episode_number');
            $series_id = Input::get('series_id');

            $seenCheck = Seen::where('episode_id', $episode_id)->where('user_id', $user_id)->count();
            if(!$seenCheck){

                $seen = new Seen;
                $seen->episode_id = $episode_id;
                $seen->user_id = $user_id;
                $seen->series_id = $series_id;
                $seen->season = $episode_season;
                $seen->episode = $episode_number;

                $seen->save();

                return Response::json(array('seen' => true));
            }
            return Response::json(array('seen' => 'Allready seen'), 500);

        }else{
            return Response::json(array('seen' => 'Unauthorized'), 500);
        }
        
    }

    public function unsetSeenEpisode(){
        if(Auth::user()){

            $episode_id = Input::get('episode_id');
            $user_id = Auth::user()->id;
            $unsee = Seen::where('episode_id', $episode_id)->where('user_id', $user_id)->delete();
            
            if($unsee){
                return Response::json(array('seen' => 'unseen'));  
            }
        }else{

            return Response::json(array('seen' => 'fail unauthorized'), 500);

        }
    }

    /*
     *
     * Find the number of unseen episodes per season for a series
     * path: /api/series/unseenamountbyseason/{series_id}/{season_number}
     *
     */

    public function getUnseenEpisodesPerSeason($series_id, $season_number){
        if(Auth::user()){

            $user_id = Auth::user()->id;
            $totalAmountofEpisodes = Episode::where('series_id', $series_id)->where('season', $season_number)->count();
            $seenAmount = Seen::where('series_id', $series_id)->where('user_id', $user_id)->where('season', $season_number)->count();

            $unseenAmountOfEpisodes = $totalAmountofEpisodes - $seenAmount;
            
            return Response::json(array('unseenepisodes' => $unseenAmountOfEpisodes));  

        }else{

            return Response::json(array('error' => 'fail unauthorized'), 500);

        }        
    }

    public function setSeenSeason(){

    }

    public function unsetSeenSeason(){

    }

    public function setSeenUntilEpisodeNumber(){

    }

}
