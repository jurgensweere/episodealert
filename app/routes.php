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
