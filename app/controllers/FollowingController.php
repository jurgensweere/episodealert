<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\Episode;
use EA\models\Series;
use EA\models\Following;
use EA\models\User;
use EA\models\Seen;
use Auth;
use DB;
use DateTime;
use Input;

class FollowingController extends BaseController
{
    public function follow($series_id){

        if(Auth::user()){
            $user_id = Auth::user()->id;

            $followingCheck = Following::where('series_id', $series_id)->where('user_id', $user_id)->count();

            if(!$followingCheck){

                $following = new Following;
                $following->series_id = $series_id;
                $following->user_id = $user_id;

                if($following->save()){
                    return Response::json(array('follow' => 'success'));
                }else{
                    return Response::json(array('follow' => 'fail to save'));
                }
            }else{
                return Response::json(array('follow' => 'allready following'));
            }

        }else{
            return Response::json(array('follow' => 'fail unauthorized'));
        }

    }

    public function unfollow($series_id){
        if(Auth::user()){

            $user_id = Auth::user()->id;
            $unfollow = Following::where('series_id', $series_id)->where('user_id', $user_id)->delete();

            if($unfollow){
                return Response::json(array('follow' => 'unfollow'));
            }
        }else{

            return Response::json(array('follow' => 'fail unauthorized'), 500);

        }

    }

    /*
     * Get all the series that the user is following for the profile page
     */
    public function getFollowingSeries(){
        $user = Auth::user();
        if($user){

            $query = Following::where('user_id', $user->id)
                ->select('following.archive', 'series.*')
                ->join('series', 'following.series_id', '=', 'series.id');

            if (!filter_var(Input::get('archive', 'true'), FILTER_VALIDATE_BOOLEAN)) {
                $query->where('following.archive', '=', 0);
            }
            if (!filter_var(Input::get('ended', 'true'), FILTER_VALIDATE_BOOLEAN)) {
                $query->where('series.status', '!=', 'Ended');
            }

            $series = $query->get();

            self::addSeenEpisodesToSeries($series, $user->id);

            if (filter_var(Input::get('seen', 'false'), FILTER_VALIDATE_BOOLEAN)) {
                $series = $series->filter(function($series) {
                    if ($series->unseen_episodes > 0) {
                        return true;
                    }
                });
            }

            self::addCurrentEpisode($series, $user->id);
            self::addLatestEpisodes($series);

            return Response::json($series);

        }else{
            return Response::json(array('flash' => 'Unauthorized, please login'));
        }
    }

    /*
     * add the total of seen_episodes and unseen_episodes to the series
     */
    private function addSeenEpisodesToSeries($series, $userid){

        foreach ($series as $s) {
            $s->seen_episodes = Seen::where('series_id', $s->id)->where('user_id', $userid)->where('season', '>', 0)->count();
            $s->unseen_episodes = Episode::where('series_id', '=', $s->id)
                ->where('season', '>', 0)
                ->where('airdate', '<', new DateTime)
                ->count() - $s->seen_episodes;
        }
    }

    /**
     * Add the next episode the user can go and watch
     */
    private function addCurrentEpisode($series, $userid)
    {
        // We figure out the latest seen episode, if any and select the next one.
        foreach ($series as $s) {
            $lastSeen = Seen::where('series_id', $s->id)
                ->where('user_id', $userid)
                ->orderBy('season', 'desc')
                ->orderBy('episode', 'desc')
                ->take(1)
                ->first();

            $s->current_episode = null;
            $season = $lastSeen ? $lastSeen->season : 1;
            $episode = $lastSeen ? $lastSeen->episode : 0;

            $currentEpisode = Episode::where('series_id', '=', $s->id)
                ->where(function ($query) use ($season, $episode) {
                    $query->where(function ($query2) use ($season, $episode) {
                        $query2->where('season', '=', $season)
                            ->where('episode', '>', $episode);
                    })->orWhere('season', '>', $season);
                })

                ->orderBy('season', 'asc')
                ->orderBy('episode', 'asc')
                ->take(1)
                ->first();

            if ($currentEpisode) {
                $s->current_episode = $currentEpisode;
            }
        }
    }

    /**
     * Add the latest episode that aired, and the next (if any)
     */
    private function addLatestEpisodes($series)
    {
        foreach ($series as $s) {
            // figure out the last aired episode, and the next
            $airdate = date('Y-m-d');
            $latest = Episode::where('series_id', '=', $s->id)
                ->where('airdate', '<=', DB::raw(
                    sprintf("IFNULL(
                        (SELECT airdate
                        FROM episode
                        WHERE series_id = %s
                        AND airdate > '%s'
                        ORDER BY season asc, episode asc
                        LIMIT 1), '%s')",
                        $s->id, $airdate, $airdate)
                    ))
                ->orderBy('season', 'desc')
                ->orderBy('episode', 'desc')
                ->take(2)
                ->get();

            // We get an array of 2 or less items:
            // [0] == next episode to air
            // [1] == last aired episode
            // if [0] is null or before $airdate, the show has no episode planned in the future

            // we will reverse the order and make sure that [1] is a future episode, otherwise we will remove it
            if ($latest != null) {
                $latest = $latest->reverse();
                if ($latest->count() == 2 && strtotime($airdate) >= strtotime($latest->get(1)->airdate)) {
                    $latest->pop();
                }
            }
            $s->latest_episodes = $latest;
        }
    }

}
