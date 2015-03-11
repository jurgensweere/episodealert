<?php namespace EA;

use App;
use Log;
use Queue;
use EA\models\Series;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use DateTime;

/*
 * This command will mostly be used after migrating the production database, 
 * making it possible to update all series in the database
 */

class SeriesAll extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'series:all';

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
        $today = new DateTime;
        $today = $today->format('Y-m-d');
        
        /*
         * After migrating the live database this field should be empty so this query will collect every single series
         * The series will completly be updated (posters/fanart, categories etc)
         */
        $series = Series::where('updated_at', '<', $today)
            ->take(50000)->get();
        
//        echo count($series);
//        exit;

        $i = 0;
        foreach ($series as $s) {
            $i++;
            /* show something in the console to keep track of progress */
            echo "\n".$i;
            Queue::push('EA\TvdbJob@updateSingleSeries', array('tvdbid' => $s->id));    
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
        return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
        return [];
	}

}
