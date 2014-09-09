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

Route::group(
    array('namespace' => 'EA\controllers'),
    function () {
        Route::get('/', 'HomeController@showWelcome');
        Route::get('/testpage', 'HomeController@showTestPage');

        Route::group(array('prefix' => 'api'), function () {
            //Auth
            Route::post('auth/login', 'AuthController@login');
            Route::get('auth/logout', 'AuthController@logout');

            Route::get('auth/expiry', function(){
                return Response::json(array('flash' => 'Session expired'), 401);        
            });

            //Series
            Route::get('series/top', 'SeriesController@top');
            Route::get('series/search/{query}', 'SeriesController@search');
            Route::get('series/{uniqueName}', 'SeriesController@getSeries');
            Route::get('series/genre/{genre}', 'SeriesController@getByGenre');
            Route::get('series/browse', 'SeriesController@getAllCategories');

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