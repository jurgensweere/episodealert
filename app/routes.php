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

Route::get('/', 'EA\controllers\HomeController@showWelcome');
Route::get('/contact', 'EA\controllers\HomeController@showContact');
Route::get('/privacy', 'EA\controllers\HomeController@showPrivacy');
Route::get('/about', 'EA\controllers\HomeController@showAbout');
Route::get('/login', 'EA\controllers\LoginController@showLogin');
