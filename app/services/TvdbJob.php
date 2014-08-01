<?php namespace EA;

use App;
use DB;
use Log;
use EA\models\Series;
use EA\models\Episode;

class TvdbJob
{
    public function updateSingleSeries($job, $data)
    {
        $tvdbid = intval($data['tvdbid']);
        if ($tvdbid == 0) {
            Log::info("TvdbJob.updateSingleSeries: Invalid TVDB Id");
            $job->delete();
        }

        Log::info("TvdbJob.updateSingleSeries: Processing TVDBId: $tvdbid");

        // Do we have this TVDB Id?
        $series = Series::whereTvdbId($tvdbid)->first();
        if ($series == null) {
            $series = new Series;
            $series->tvdb_id = $tvdbid;
        }

        // Fetch TVDB data
        $data = App::make('tvdb')->getSerieData($series->tvdb_id, true);
        if (!is_array($data)) {
            Log::error("Something went wrong when downloading from TVDB");
            return;
        }

        // Lege series skippen we
        if (App::make('tvdb')->isEmptySeries($data)) {
            // Remove empty if exists
            $series->delete();
            return;
        }

        // Update Series data
        $series->name = $data['name'];
        $series->description = $data['description'];
        $series->status = $data['status'];
        if ($data['imdb_id'] != '') {
            $series->imdb_id = $data['imdb_id'];
        }
        if ($data['firstaired'] != '') {
            $series->firstaired = $data['firstaired'];
        }

        // If the series doesn't have a unique name, assign one
        if (empty($series->unique_name)) {
            $series->assignUniqueName();
        }

        $series->save();

        //EA_Service_SeriesService::updateRating($serie);

        Log::info("TvdbJob.updateSingleSeries: {$series->name} Updated.");

        $this->attachEpisodeData($series, $data);

        $job->delete();
    }

    private function attachEpisodeData(Series $series, $data)
    {
        $episodes = array();
        if (!is_array($data['episodes'])) {
            return;
        }

        $tvdbids = array();
        $episodeids = array();

        foreach ($data['episodes'] as $ep) {
            $episode = Episode::whereTvdbId($ep['id'])->first();
            if (null == $episode) {
                $episode = new Episode;
                $episode->tvdb_id = $ep['id'];
            }
            $episode->season = $ep['season'];
            $episode->episode = $ep['episode'];
            $episode->airdate = $ep['airdate'];
            $episode->name = $ep['name'];
            $episode->description = $ep['description'];
            $episode->image = 'none';
            
            $series->episodes()->save($episode);

            array_push($tvdbids, $episode->tvdb_id);
            array_push($episodeids, $episode->id);

            // Update season and episode column in seen table.
            // TODO: try to get rid of those columns
            DB::table('seen')
                ->whereEpisodeId($episode->id)
                ->update(array('season' => $episode->season, 'episode' => $episode->episode));
        }

        if (count($tvdbids) > 0) {
            // we have loaded episodes, remove all those that are no longer there
            DB::table('episode')
                ->whereNotIn('tvdb_id', $tvdbids)
                ->whereSeriesId($series->id)
                ->delete();
            DB::table('seen')
                ->whereNotIn('episode_id', $episodeids)
                ->whereSeriesId($series->id)
                ->delete();
        } else {
            // We loaded a series, but it no longer has any episodes
            DB::table('episode')
                ->whereSeriesId($series->id)
                ->delete();
            DB::table('seen')
                ->whereSeriesId($series->id)
                ->delete();
        }
    }
}
