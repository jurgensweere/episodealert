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
	public function register() {

		$usernameCheck  = User::where('username', Input::get('username'))->count();

		if(!$usernameCheck){
	        $user = User::create(
	            array(
	                'accountname' => '',
	                'username' => Input::get('username'),
	                'email' => Input::get('email'),
	                'password' => Hash::make(Input::get('password')),
	                'role' => User::ROLE_MEMBER,
	                'publicfollow' => 0,
	            )
	        );


	        return Response::json(array('flash' => 'Thanks for registering'));			
		}else{
			return Response::json(array('flash' => 'Username allready in use'), 500);
		}

	}

	public function login() {
		if(Auth::attempt(array('username' => Input::json('username'), 'password' => Input::json('password'))))
		{
	  		return Response::json(array('id' => Auth::user()->id,
					'username' => Auth::user()->username,
					'email' => Auth::user()->email));
		} else {
 			 return Response::json(array('flash' => 'Invalid username or password'), 500);
		}
	}

	public function logout() {
		Auth::logout();
		return Response::json(array('flash' => 'Loggout Out!'));
	}
   
}