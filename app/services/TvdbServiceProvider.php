<?php namespace EA;

use Illuminate\Support\ServiceProvider;

class EaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('tvdb', function () {
            return new Tvdb;
        });
        $this->app->bind('series', function () {
            return new SeriesService;
        });
    }
}
