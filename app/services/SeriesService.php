<?php namespace EA;

use EA\models\Seen;
use EA\models\Episode;
use EA\models\User;
use Illuminate\Database\Eloquent\Collection;
use DB;

class SeriesService
{
    /**
     * Mark a single episode as seen
     * @param Episode $episode
     * @param User $user
     * @return Collection
     */
    public function setSeenSingleEpisode(Episode $episode, User $user)
    {
        // Did we already see this episode?
        $seen = Seen::where('episode_id', '=', $episode->id)
            ->where('user_id', '=', $user->id)
            ->first();

        // If not, create a db record.
        if ($seen == null) {
            $seen = new Seen;
            $seen->episode_id = $episode->id;
            $seen->user_id = $user->id;
            $seen->series_id = $episode->series_id;
            $seen->season = $episode->season;
            $seen->episode = $episode->episode;

            $seen->save();
        }

        $collection = new Collection;
        $collection->add($seen);
        return $collection;
    }

    /**
     * Mark an episode as unseen
     * @param Episode $episode
     * @param User $user
     * @return array
     */
    public function setUnseenSingleEpisode(Episode $episode, User $user)
    {
        // Simply try to delete the record
        $seen = Seen::where('episode_id', '=', $episode->id)
            ->where('user_id', '=', $user->id)
            ->delete();

        return array($episode->id);
    }

    /**
     * Mark all episodes up and until the given one as seen
     * @param Episode $episode
     * @param User $user
     * @return Collection
     */
    public function setSeenUntilEpisode(Episode $episode, User $user)
    {
        // Grab all the episodes we need to mark as seen
        $query = Episode::leftJoin('seen', function ($join) use ($episode, $user) {
                $join->on('seen.episode_id', '=', 'episode.id');
                $join->on('seen.user_id', '=', DB::raw($user->id));
        })
            ->where('episode.series_id', '=', $episode->series_id)
            ->where(function ($query) use ($episode) {
                $query->where('episode.season', '<', $episode->season)
                    ->orWhere(function ($query) use ($episode) {
                        $query->where('episode.season', '=', $episode->season);
                        $query->where('episode.episode', '<=', $episode->episode);
                    });
            })
            ->whereNull('seen.id');

        // Ignore Specials, unless user presses "Until here" in the specials season
        if ($episode->season > 0) {
            $query->where('episode.season', '>', 0);
        }

        $episodes = $query->get(array('episode.*'));
        $collection = new Collection;

        // create the seen records
        foreach ($episodes as $e) {
            $seen = new Seen;
            $seen->episode_id = $e->id;
            $seen->user_id = $user->id;
            $seen->series_id = $e->series_id;
            $seen->season = $e->season;
            $seen->episode = $e->episode;

            $seen->save();
            $collection->add($seen);
        }

        return $collection;
    }

    /**
     * Mark all episodes as unseen up and until the given one
     * @param Episode $episode
     * @param User $user
     */
    public function setUnseenUntilEpisode(Episode $episode, User $user)
    {
        // simply delete the seen records
        $query = Seen::where('user_id', '=', $user->id)
            ->where('series_id', '=', $episode->series_id)
            ->where(function ($query) use ($episode) {
                $query->where('season', '<', $episode->season)
                    ->orWhere(function ($query) use ($episode) {
                        $query->where('season', '=', $episode->season);
                        $query->where('episode', '<=', $episode->episode);
                    });
            });
        $unseen = $query->get();
        $query->delete();

        return $unseen->lists('episode_id');
    }

    /**
     * Mark an entire season seen
     * @param Episode $episode
     * @param User $user
     * @return Collection
     */
    public function setSeenSeason(Episode $episode, User $user)
    {
        // Grab all the episodes we need to mark as seen
        $episodes = Episode::leftJoin('seen', function ($join) use ($episode, $user) {
                $join->on('seen.episode_id', '=', 'episode.id');
                $join->on('seen.user_id', '=', DB::raw($user->id));
        })
            ->where('episode.series_id', '=', $episode->series_id)
            ->where('episode.season', '=', $episode->season)
            ->whereNull('seen.id')
            ->get(array('episode.*'));

        $collection = new Collection;

        // create the seen records
        foreach ($episodes as $e) {
            $seen = new Seen;
            $seen->episode_id = $e->id;
            $seen->user_id = $user->id;
            $seen->series_id = $e->series_id;
            $seen->season = $e->season;
            $seen->episode = $e->episode;

            $seen->save();
            $collection->add($seen);
        }

        return $collection;
    }

    /**
     * Mark an entire season unseen
     * @param Episode $episode
     * @param User $user
     */
    public function setUnseenSeason(Episode $episode, User $user)
    {
        $query = Seen::where('user_id', '=', $user->id)
            ->where('series_id', '=', $episode->series_id)
            ->where('season', '=', $episode->season);

        $unseen = $query->get();
        $query->delete();

        return $unseen->lists('episode_id');
    }
}
