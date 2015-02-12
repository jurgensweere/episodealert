<?php namespace EA\controllers;

use BaseController;
use Response;
use EA\models\User;
use Auth;
use Validator;
use Input;

class ProfileController extends BaseController
{
    public function getUserData()
    {
        $user = Auth::user();
        // you can only change the password, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in'), 403);
        }

        unset($user->oauthprovider);
        unset($user->oauthid);
        unset($user->password);
        unset($user->username);
        unset($user->remember_token);

        return Response::json($user);
    }

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
            Input::all(),
            array(
                'oldpassword' => 'required|hashmatch:password',
                'password' => 'required|min:6|confirmation',
            )
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
            return Response::json(array('flash' => 'You need to log in.'), 403);
        }

        $validator = Validator::make(
            Input::all(),
            array(
                'username' => 'min:4|max:20',
                'email' => 'email',
            )
        );

        if ($validator->fails())
        {
            return Response::json(
                array(
                    'flash' => 'Invalid data',
                    'username' => $user->accountname,
                    'email' => $user->email,
                ), 400);
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

        return Response::json(
            array(
                'flash' => 'Saved',
                'username' => $user->accountname,
                'email' => $user->email,
            ), 200);
    }

    public function postChangePreferences()
    {
        $user = Auth::user();

        // you can only change name or email, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in.'), 403);
        }

        $validator = Validator::make(
            Input::all(),
            array(
                'publicfollow' => 'required|boolean',
                'alerts' => 'required|boolean',
            )
        );

        if ($validator->fails())
        {
            return Response::json(
                array(
                    'flash' => 'Invalid data',
                    'publicfollow' => $user->publicfollow == 1,
                    'alerts' => $user->alerts == 1,
                ), 400);
        }

        $user->publicfollow = Input::get('publicfollow');
        $user->alerts = Input::get('alerts');
        $user->save();

        return Response::json(
            array(
                'flash' => 'Saved',
                'publicfollow' => $user->publicfollow == 1,
                'alerts' => $user->alerts == 1,
            ), 200);
    }
}
