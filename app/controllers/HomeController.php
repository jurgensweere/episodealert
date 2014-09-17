<?php namespace EA\controllers;

use BaseController;
use View;
use EA\Tvdb;
use EA\TvdbJob;
use EA\models\Series;
use Auth;

class HomeController extends BaseController
{

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function showWelcome()
    {
        return View::make('index');
    }

    public function showTestPage(){
        //print_r(Auth::user());

        //self::resize_image('public/img/poster/lo/lost.jpg', 'public/img/poster/lo/lost_small.jpg', 50, 0.3);
        //self::resize_image('public/img/poster/lo/lost.jpg', 'public/img/poster/lo/lost_medium.jpg', 50, 0.5);
        //self::resize_image('public/img/poster/lo/lost.jpg', 'public/img/poster/lo/lost_large.jpg', 50, 0.8);

        
        $tv = new Tvdb;
        $series =  $tv->getSerieData(80348, false);

        //$tv->getBannerImage($series);


        //$tv->getPosterImage($series, 'kaas');

    }  


}
