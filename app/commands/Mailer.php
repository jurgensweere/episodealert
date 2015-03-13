<?php namespace EA;

use App;
use Log;
use Queue;
use EA\models\Following;
use EA\models\User;
use EA\models\Episode;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use DateTime;
use DateInterval;
use URL;

class Mailer extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mailer:batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Episode Alerts.';

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
        $yesterday = new DateTime;
        $yesterday->sub(new DateInterval('P1D'));
        $yesterday = $yesterday->format('Y-m-d');   
        
        $today = new DateTime;
        $today = $today->format('Y-m-d');
        
        //TODO:get users that have not been updated today!
        $users = User::where('alerts', '=', 1)
            ->where('last_notified', '<', $today)
            ->orWhereNull('last_notified')
            ->take(100)->get();

        foreach ($users as $user) {
            $userEpisodesList = array();

            $following = Following::where('user_id', $user->id)
                ->select('following.archive', 'series.*')
                ->join('series', 'following.series_id', '=', 'series.id')->get();


            foreach ($following as $f) {
                $yesterdayEpisode = Episode::where('series_id', '=', $f->id)->where('airdate', '=', $yesterday)->get();

                foreach ($yesterdayEpisode as $episode) {
                    array_push($userEpisodesList, ['series' => $f->name,
                                                   'unique_name' => $f->unique_name,
                                                   'season' => $episode->season,
                                                   'number' => $episode->episode,
                                                   'name' => $episode->name]);
                }
            } 
            
            if(count($following) > 0){
                $mailname = $user->accountname;                
            
                $data = array(
                    'episodelist' => $userEpisodesList,
                    'username' => $mailname,
                    'email' => $user->email,
                    'base_url' => URL::to('/'),
                    'user_id' => $user->id
                );

                if(count($userEpisodesList) > 0) {
                    Queue::push('EA\MailJob@sendAlertEmail', $data);
                }
            }
            
            $user->last_notified = new DateTime;
            $user->save();            
        }        
        
        
//        $this->info("Mailer: Start Scheduling emails.");
//
//        $yesterday = new DateTime;
//        $yesterday->sub(new DateInterval('P1D'));
//        $yesterday = $yesterday->format('Y-m-d');
//        //$yesterday = '2015-01-21'; // Debug test
//
//        // TODO: this is guaranteed to be a performance issue. We need to batch these in chunks
//        // I've added the last_notified column to enable batching
//        // we need to get a list of series that had an episode yesterday
//        $followings = Following::join('episode', 'episode.series_id', '=', 'following.series_id')
//            ->join('user', 'user.id', '=', 'following.user_id')
//            ->where('user.alerts', '=', 1)
//            ->where('episode.airdate', '=', $yesterday)
//            ->where(function($query) {
//                $query->whereNull('following.last_notified');
//                $query->orWhere('following.last_notified', '<', new DateTime);
//            })
//            ->get(array('following.id', 'episode.id as episode_id'));
//
//        foreach ($followings as $f) {
//            // Queue an email
//            Log::info("Push a mail job");
//            Queue::push('EA\MailJob@sendAlertEmail', array('following_id' => $f->id, 'episode_id' => $f->episode_id));
//        }

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