<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\User;
use Auth;
use Validator;
use Input;

class ProfileController extends BaseController
{
    public function postChangePassword()
    {
        $user = Auth::user();
        // you can only change the password, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in to change password'), 403);
        }
        // you can only change the password, if you're not logged in via 3rd party
        if ($user->isThirdParty()) {
            return Response::json(array('flash' => 'You cannot change your password'), 403);
        }

        Validator::extend('hashmatch', function($attribute, $value, $parameters)
        {
            return Hash::check($value, Auth::user()->$parameters[0]);
        });

        $validator = Validator::make(
            array('oldpassword' => 'required|hashmatch:password'),
            array('password' => 'required|min:6|confirmation')
        );

        if ($validator->fails())
        {
            return Response::json(array('flash' => 'Error saving password'), 400);
        }

        // change the password.
        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return Response::json(array('flash' => 'Password Saved'), 200);
    }

    public function postChangeCredentials()
    {
        $user = Auth::user();

        // you can only change name or email, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log.'), 403);
        }

        $validator = Validator::make(
            array('username' => 'min:4|max:20'),
            array('email' => 'email')
        );

        if ($validator->fails())
        {
            return Response::json(array('flash' => 'Error saving password'), 400);
        }

        $username = Input::get('username');
        $email = Input::get('email');

        if (strlen(trim($username)) > 0) {
            $user->accountname = $username;
        }

        if (strlen(trim($email)) > 0) {
            $user->email = $email;
        }
        $user->save();

        return Response::json(array('flash' => 'Saved'), 200);
    }
}
