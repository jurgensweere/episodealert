<?php namespace EA;

use App;
use Log;
use Queue;
use EA\models\Series;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use DateTime;
use DateInterval;
use URL;
use DB;
use Blade;

class Sitemap extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a sitemap.';

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
        $this->info("Sitemap: Start generating sitemap.");

        Blade::setContentTags('{{', '}}');
        Blade::setEscapedContentTags('{{{', '}}}');

        // create new sitemap object
        $sitemap = App::make("sitemap");

        // add items to the sitemap (url, date, priority, freq)
        $sitemap->add(URL::to(''), date('c'), '1.0', 'daily');
        $sitemap->add(URL::to('trending'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/action'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/adventure'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/animation'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/comedy'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/children'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/crime'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/drama'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/documentary'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/fantasy'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/game%20show'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/horror'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/news'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/reality'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/science-fiction'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/soap'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/sport'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/talk%20show'), date('c'), '0.9', 'weekly');
        $sitemap->add(URL::to('series/genre/western'), date('c'), '0.9', 'weekly');

        // get all series from db
        $series = Series::orderBy('updated_at', 'desc')->get();

        // add every post to the sitemap
        foreach ($series as $s) {
            $sitemap->add(URL::to('series/' . $s->unique_name), $s->updated_at->format('c'), '0.5', 'monthly');
        }

        // generate your sitemap (format, filename)
        $sitemap->store('xml', 'sitemap');

        $this->info("Sitemap: completed.");
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
