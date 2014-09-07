<?php namespace EA\controllers;

use Auth;
use EA\models\User;
use BaseController;
use Input;
use Redirect;
use Validator;
use View;
use Response;
use Hash;

class AuthController extends BaseController
{

 public function login()
  {
    if(Auth::attempt(array('username' => Input::json('username'), 'password' => Input::json('password'))))
    {
      return Response::json(Auth::user());
    } else {
      return Response::json(array('flash' => 'Invalid username or password'), 500);
    }
  }

	public function logout(){

		Auth::logout();
		return Response::json(array('flash' => 'Loggout Out!'));
	}
   
}