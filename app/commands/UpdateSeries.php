<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateSeries extends Command {

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
        if($lastUpdateTime == 0) $lastUpdateTime = time() - 1 * 24 * 60 * 60;

        $data = App::make('tvdb')->getSeriesUpdates($lastUpdateTime);
        
        if($data) {
            $lastUpdateTime = $data->Time;
            Settings::store('lastUpdateTime', $lastUpdateTime);

            $series_count = $data ? count($data->Series) : 0;
            //$this->log($series_count . " series downloaded from thetvdb.com");
            if($series_count > 0) {
                //$now = date("Y-m-d H:i:s");
                //$db = Zend_Registry::get("db");
                // foreach( $data->Series as $series_id ) {
                //     $sql = 'INSERT INTO update_queue (tvdb_serieid, added) VALUES (?, ?)
                //       ON DUPLICATE KEY UPDATE tvdb_serieid = ?, added = ?, retries = 0';
                //     $values = array('tvdb_serieid'=>$series_id, 'added'=>$now);

                //     $db->query($sql, array_merge(array_values($values), array_values($values)));
                // }
            }
        } else {
            // $this->log("Download error.");
        }
        // $this->log("Done.");
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
