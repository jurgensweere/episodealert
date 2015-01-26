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
        $series = Series::find($tvdbid);
        if ($series == null) {
            $series = new Series;
            $series->id = $tvdbid;
        }

        // Fetch TVDB data
        $data = App::make('tvdb')->getSerieData($series->id, true);
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
        if ($data['rating'] != '') {
            $series->rating = $data['rating'];
        }
        if ($data['category'] != '') {
            $series->category = $data['category'];
        }  
        $series->episode_amount = 0; // Default to 0, we will update these values in attachEpisodeData     

        // If the series doesn't have a unique name, assign one
        if (empty($series->unique_name)) {
            $series->assignUniqueName();
        }

        $series->save();

        //EA_Service_SeriesService::updateRating($serie);

        Log::info("TvdbJob.updateSingleSeries: {$series->name} Updated.");

        $this->attachEpisodeData($series, $data);


        if($series->poster_image_converted == 0){
            $this->attachSeriesPoster($series);    
        }

        //Find out if there is a special season and save it in series table
        $firstEpisode = Episode::where('series_id', $series->id )->select('season')->orderBy('season', 'asc')->first();
        $lastEpisode = Episode::where('series_id', $series->id )->select('season')->orderBy('season', 'desc')->first();
        $series->season_amount = $lastEpisode ? $lastEpisode->season : 0;

        if($firstEpisode && $firstEpisode->season == 0){
        	$series->has_specials = 1;
        }

        $series->save();

        $job->delete();
    }

    public function attachSeriesPoster($series){
        //echo "trying to getSeriesData: " . $series->id;
        //echo "\n";

        $data = App::make('tvdb')->getSerieData($series->id, false);

        //echo $data['id'];
        //echo "\n";

        //Try to get fanart for the series
        $fanart = App::make('tvdb')->getBannerImage($series);

        if($fanart){
            $series->fanart_image = $series->unique_name.".jpg";
            $series->save();        	
        }

        if($data['poster']!=""){
            $poster = App::make('tvdb')->getPosterImage($series, $data['poster']);            
        }else{
            $poster = false;
        }

        if($poster){
            $series->poster_image = $series->unique_name.".jpg";
            $series->poster_image_converted = 1;
            $series->save();
        }
    }

    private function attachEpisodeData(Series $series, $data)
    {
        $episodes = array();
        if (!is_array($data['episodes'])) {
            return;
        }

        $episodeids = array();
        $episode_amount = 0;
        $specials_amount = 0;

        foreach ($data['episodes'] as $ep) {
            $episode = Episode::find($ep['id']);
            if (null == $episode) {
                $episode = new Episode;
                $episode->id = $ep['id'];
            }
            $episode->season = $ep['season'];
            $episode->episode = $ep['episode'];
            $episode->airdate = $ep['airdate'];
            $episode->name = $ep['name'];
            $episode->description = $ep['description'];
            $episode->image = 'none';
            
            $series->episodes()->save($episode);

            if ($episode->season > 0) {
                $episode_amount++;
            } else {
                $specials_amount++;
            }

            array_push($episodeids, $episode->id);

            // Update season and episode column in seen table.
            // TODO: try to get rid of those columns
            DB::table('seen')
                ->whereEpisodeId($episode->id)
                ->update(array('season' => $episode->season, 'episode' => $episode->episode));
        }
        $series->episode_amount = $episode_amount;
        $series->specials_amount = $specials_amount;

        if (count($episodeids) > 0) {
            // we have loaded episodes, remove all those that are no longer there
            DB::table('episode')
                ->whereNotIn('id', $episodeids)
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
