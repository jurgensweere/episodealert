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
    public function follow(Series $series)
    {

        if (Auth::user()) {
            $user = Auth::user();

            $followingCheck = Following::where('series_id', $series->id)->where('user_id', $user->id)->count();

            if (!$followingCheck) {
                $following = new Following;
                $following->series_id = $series->id;
                $following->user_id = $user->id;

                if ($following->save()) {
                    $user->following = Following::where('user_id', '=', $user->id)->count();
                    $user->save();
                    $series->trend = Following::where('series_id', '=', $series->id)->count();
                    $series->save();
                    return Response::json(array('follow' => 'Success.'));
                } else {
                    return Response::json(array('follow' => 'A server error occurred, please try again.'), 500);
                }
            } else {
                return Response::json(array('follow' => 'You are already following this series.'), 409);
            }

        } else {
            return Response::json(array('follow' => 'You need to log in first.'), 401);
        }

    }

    public function unfollow(Series $series)
    {
        if (Auth::user()) {
            $user = Auth::user();
            $unfollow = Following::where('series_id', $series->id)->where('user_id', $user->id)->delete();

            //Delete seen information on unfollow
            Seen::where('user_id', Auth::user()->id)->where('series_id', '=', $series->id)->delete();

            if ($unfollow) {
                $user->following = Following::where('user_id', '=', $user->id)->count();
                $user->save();
                $series->trend = Following::where('series_id', '=', $series->id)->count();
                $series->save();
                return Response::json(array('follow' => 'Success.'));
            }
        } else {
            return Response::json(array('follow' => 'You need to log in first.'), 401);

        }

    }

    /*
     * Get all the series that the user is following for the profile page
     */
    public function getFollowingSeries()
    {
        $user = Auth::user();
        if ($user) {
            $query = Following::where('user_id', $user->id)
                ->select('following.archive', 'series.*')
                ->join('series', 'following.series_id', '=', 'series.id');

            if (!filter_var(Input::get('archive', 'true'), FILTER_VALIDATE_BOOLEAN)) {
                $query->where('following.archive', '=', 0);
            }
            if (!filter_var(Input::get('ended', 'true'), FILTER_VALIDATE_BOOLEAN)) {
                $query->where('series.status', '!=', 'Ended');
            }

            $series = $query
                ->orderBy('following.archive', 'asc')
                ->get();

            self::addSeenEpisodesToSeries($series, $user->id);

            if (filter_var(Input::get('seen', 'false'), FILTER_VALIDATE_BOOLEAN)) {
                $series = $series->filter(function ($series) {
                    if ($series->unseen_episodes > 0) {
                        return true;
                    }
                });
            }

            //self::addCurrentEpisode($series, $user->id);
            //self::addLatestEpisodes($series);

            return Response::json($series);
        } else {
            return Response::json(array('flash' => 'You need to log in first.'), 401);
        }
    }

    /*
     * add the total of seen_episodes and unseen_episodes to the series
     */
    private function addSeenEpisodesToSeries($series, $userid)
    {
        $seenPerSeries = Seen::whereIn('series_id', $series->modelKeys())
            ->where('user_id', '=', $userid)
            ->where('season', '>', 0)
            ->groupBy('series_id')
            ->get(['series_id', DB::raw('count(*) as seen')])
            ->keyBy('series_id');

        $episodesPerSeries = Episode::whereIn('series_id', $series->modelKeys())
            ->where('season', '>', 0)
            ->where('airdate', '<', new DateTime('today'))
            ->groupBy('series_id')
            ->get(['series_id', DB::raw('count(*) as episodes')])
            ->keyBy('series_id');

        foreach ($series as $s) {
            $s->seen_episodes = isset($seenPerSeries[$s->id]) ? $seenPerSeries[$s->id]->seen : 0;
            $s->unseen_episodes = (
                isset($episodesPerSeries[$s->id]) ? $episodesPerSeries[$s->id]->episodes : 0
            ) - $s->seen_episodes;
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
                    sprintf(
                        "IFNULL(
                        (SELECT airdate
                        FROM episode
                        WHERE series_id = %s
                        AND airdate > '%s'
                        ORDER BY season asc, episode asc
                        LIMIT 1), '%s')",
                        $s->id,
                        $airdate,
                        $airdate
                    )
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

    public function postArchive(Series $series)
    {
        Following::where('user_id', '=', Auth::user()->id)
            ->where('series_id', '=', $series->id)
            ->update(array(
                'archive' => 1
                ));

        return Response::json($series);
    }

    public function postRestore(Series $series)
    {
        Following::where('user_id', '=', Auth::user()->id)
            ->where('series_id', '=', $series->id)
            ->update(array(
                'archive' => 0
                ));
        return Response::json($series);
    }
}
