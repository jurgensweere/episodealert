<?php namespace EA;

use App;
use Log;
use Queue;
use EA\models\Settings;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateSeries extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'series:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $lastUpdateTime = Settings::whereKey('lastUpdateTime')->pluck('value');
        if ($lastUpdateTime == 0) {
            $lastUpdateTime = time() - 1 * 24 * 60 * 60;
        }

        // Debug
        //Queue::push('EA\TvdbJob@updateSingleSeries', array('tvdbid' => 258743));
        //exit;

        $data = App::make('tvdb')->getSeriesUpdates($lastUpdateTime);
        
        if ($data) {
            $lastUpdateTime = $data->Time;
            Settings::store('lastUpdateTime', $lastUpdateTime);

            $series_count = $data ? count($data->Series) : 0;
            Log::info("UpdateSeries: $series_count series downloaded from thetvdb.com");

            if ($series_count > 0) {
                foreach ($data->Series as $series_id) {
                    Queue::push('EA\TvdbJob@updateSingleSeries', array('tvdbid' => $series_id->__toString()));
                }
            }
        } else {
            Log::error("UpdateSeries: Error while downloading Series data from TVDB");
        }
        Log::info("UpdateSeries: Done.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
        );
    }
}
