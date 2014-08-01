<?php namespace EA;

use App;
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

        // Serie gegevens bijwerken
        $series->tvdb_id = $tvdbid;
        $series->name = $data['name']; // naam is nodig om een unique name te maken.
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

        //      EA_Service_SeriesService::updateEpisodeData($serie, $serie_data);

        //      $count = is_array($serie_data['episodes']) ? count($serie_data['episodes']) : 0;
        //      $this->log("$count episodes done.");
  //                               //$this->log("Time passed: " . (microtime(true) - $starttime ));
        //      // Serie is verwerkt, queue bijwerken
        //      $this->markAsProcessed($tvdbid);
  //                               $this->updateRetryQueue($tvdbid);
        //  }
        // }

        $job->delete();
    }
}
