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

Route::model('episode', 'EA\models\Episode');
Route::model('series', 'EA\models\Series');
Route::model('user', 'EA\models\User');

Route::group(
    array('namespace' => 'EA\controllers'),
    function () {

        Route::get('/', 'HomeController@showWelcome');
        Route::get('/testpage', 'HomeController@showTestPage');
        Route::get('/login', 'LoginController@processLogin');


        Route::get('/admin', array('before' => 'auth.admin', 'uses' => 'AdminController@showAdminPage'));
        Route::get('/admin/{all}', array('before' => 'auth.admin', 'uses' => 'AdminController@showAdminPage'))
            ->where('all', '.*');

        Route::group(array('prefix' => 'api'), function () {

            // Private API calls which require a user
            Route::group(array('before' => 'auth'), function () {
                Route::get('profile/following', 'FollowingController@getFollowingSeries');

                // Series
                Route::get('series/guide', 'SeriesController@getEpisodeGuide');
                Route::get('series/episodesperdate/{date}', 'SeriesController@getEpisodesForUserPerDate');
                Route::get('series/unseenamount', 'SeriesController@getUnseenEpisodes');
                Route::get(
                    'series/unseenamountbyseason/{series_id}/{season}',
                    'SeriesController@getUnseenEpisodesPerSeason'
                );
                Route::get(
                    'series/unseenamountbyseries/{series_id}/{seasons}',
                    'SeriesController@getUnseenEpisodesPerSeries'
                );

                // Following
                Route::get('follow/{series}', 'FollowingController@follow');
                Route::get('unfollow/{series}', 'FollowingController@unfollow');
                Route::post('series/archive/{series}', 'FollowingController@postArchive');
                Route::post('series/restore/{series}', 'FollowingController@postRestore');

                //Seen
                Route::post('series/seen/{episode}', 'SeriesController@setSeenEpisode');
                Route::post('series/unseen/{episode}', 'SeriesController@unsetSeenEpisode');

                // Profile
                Route::get('profile', 'ProfileController@getUserData');
                Route::get('profile/stats', 'ProfileController@getStats');
                Route::post('profile/order', 'ProfileController@postOrder');
                Route::post('profile/password', 'ProfileController@postChangePassword');
                Route::post('profile/credentials', 'ProfileController@postChangeCredentials');
                Route::post('profile/preferences', 'ProfileController@postChangePreferences');
            });

            // Admin api calls
            Route::group(array('before' => 'auth.admin'), function () {
                Route::get('/user', 'UserController@getUsers');
                Route::get('/user/{user}', 'UserController@getUser');
                Route::get('/user/{user}/assumedirectcontrol', 'UserController@getAssumeDirectControl');
                Route::get('/admin/series', 'SeriesController@getSeriesPaginated');
            });

            //Auth
            Route::post('auth/register', 'AuthController@register');
            Route::post('auth/login', 'AuthController@login');
            Route::get('auth/check', 'AuthController@checkAuth');
            Route::get('auth/logout', 'AuthController@logout');
            Route::post('password/reminder', 'RemindersController@postRemind');
            Route::post('password/reset', 'RemindersController@postReset');

            Route::post('auth/oauth/google', 'AuthController@callbackGoogleOAuth');
            Route::post('auth/oauth/google/logout', 'AuthController@logoutGoogleOAuth');
            Route::post('auth/oauth/facebook', 'AuthController@callbackFacebookOAuth');

            // Public API calls
            Route::get('series/top', 'SeriesController@top');

            // Series
            Route::get('series/trending', 'SeriesController@trending');
            Route::get('series/genre/{genre}/{skip?}', 'SeriesController@getByGenre');
            Route::get('series/search/{query}', 'SeriesController@search');
            Route::get('series/browse', 'SeriesController@getAllCategories');
            Route::get('series/episodes/{series_id}', 'SeriesController@getEpisodes');
            Route::get('series/episodesbyseason/{series_id}/{season}', 'SeriesController@getEpisodesBySeason');
            Route::get('series/{uniqueName}', 'SeriesController@getSeries');

            Route::get('auth/expiry', function () {
                return Response::json(array('flash' => 'Session expired'), 401);
            });
        });
    }
);

// =============================================
// CATCH ALL ROUTE =============================
// =============================================
// all routes that are not home or api will be redirected to the frontend
// this allows angular to route them
App::missing(
    function ($exception) {
        return App::make('EA\controllers\HomeController')->showWelcome();
    }
);
