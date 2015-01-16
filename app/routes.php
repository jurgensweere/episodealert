<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Changing the blade brackets so they dont conflict with angular
Blade::setContentTags('<%', '%>');
Blade::setEscapedContentTags('<%%', '%%>');


Route::group(
    array('namespace' => 'EA\controllers'),
    function () {

        Route::get('/', 'HomeController@showWelcome');
        Route::get('/testpage', 'HomeController@showTestPage');

        Route::group(array('prefix' => 'api'), function () {

            //Auth
            Route::post('auth/register', 'AuthController@register');
            Route::post('auth/login', 'AuthController@login');

    		Route::get('auth/check', 'AuthController@checkAuth');

            Route::get('auth/logout', 'AuthController@logout');
            Route::get('profile/following', 'FollowingController@getFollowingSeries');

            Route::get('auth/expiry', function(){
                return Response::json(array('flash' => 'Session expired'), 401);        
            });

            //Following (has to go behind auth)
            Route::get('follow/{series_id}', 'FollowingController@follow');
            Route::get('unfollow/{series_id}', 'FollowingController@unfollow');

            //Series
            Route::get('series/top', 'SeriesController@top');
            Route::get('series/search/{query}', 'SeriesController@search');
            Route::get('series/genre/{genre}', 'SeriesController@getByGenre');
            Route::get('series/browse', 'SeriesController@getAllCategories');
            Route::get('series/episodes/{uniqueName}', 'SeriesController@getEpisodes');
            Route::get('series/episodesbyseason/{series}/{season}', 'SeriesController@getEpisodesBySeason');
            Route::get('series/unseenamount', 'SeriesController@getUnseenEpisodes');
            Route::get('series/unseenamountbyseason/{series_id}/{season}', 'SeriesController@getUnseenEpisodesPerSeason');
            Route::get('series/unseenamountbyseries/{series_id}/{seasons}', 'SeriesController@getUnseenEpisodesPerSeries');
            Route::get('series/{uniqueName}', 'SeriesController@getSeries');
            
            //Seen
            Route::post('series/seen/', 'SeriesController@setSeenEpisode');
            Route::post('series/unseen/', 'SeriesController@unsetSeenEpisode');

        });

        // Route::get('/contact', 'HomeController@showContact');
        // Route::get('/privacy', 'HomeController@showPrivacy');
        // Route::get('/about', 'HomeController@showAbout');

        // Route::get('/login', 'LoginController@showLogin');
        // Route::get('/login/passwordreset', 'LoginController@showPasswordReset');
        // Route::post('/login/passwordreset', 'LoginController@submitPasswordReset');
        // Route::get('/login/register', 'LoginController@showRegister');
        // Route::post('/login/register', 'LoginController@submitRegister');
    }
);

// =============================================
// CATCH ALL ROUTE =============================
// =============================================
// all routes that are not home or api will be redirected to the frontend
// this allows angular to route them
App::missing(function($exception)
{
    return View::make('index');
});