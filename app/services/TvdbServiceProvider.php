<?php namespace EA;

use Illuminate\Support\ServiceProvider;

class TvdbServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('tvdb', function()
        {
            return new Tvdb;
        });
    }
}
