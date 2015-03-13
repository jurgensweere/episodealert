<?php namespace EA\controllers;

use Auth;
use BaseController;
use DB;
use EA\models\User;
use Hash;
use Input;
use Response;
use Validator;

class ProfileController extends BaseController
{
    public function getUserData()
    {
        $user = Auth::user();
        // you can only change the password, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in first.'), 401);
        }

        unset($user->oauthprovider);
        unset($user->oauthid);
        unset($user->password);
        unset($user->remember_token);

        return Response::json($user);
    }

    public function postChangePassword()
    {
        $user = Auth::user();
        // you can only change the password, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in to change password.'), 401);
        }
        // you can only change the password, if you're not logged in via 3rd party
        if ($user->isThirdParty()) {
            return Response::json(array('flash' => 'You cannot change your password.'), 403);
        }

        Validator::extend('hashmatch', function ($attribute, $value, $parameters) {
        
            return Hash::check($value, Auth::user()->$parameters[0]);
        });

        $validator = Validator::make(
            Input::all(),
            array(
                'oldpassword' => 'required|hashmatch:password',
                'password' => 'required|min:6|confirmation',
            )
        );

        if ($validator->fails()) {
        return Response::json(array('flash' => 'Error saving password.'), 400);
        }

        // change the password.
        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return Response::json(array('flash' => 'Password Saved'));
    }

    public function postChangeCredentials()
    {
        $user = Auth::user();

        // you can only change name or email, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in first.'), 401);
        }

        $validator = Validator::make(
            Input::all(),
            array(
                'accountname' => 'min:4|max:20',
                'email' => 'email',
            )
        );

        if ($validator->fails()) {
            return Response::json(
            array(
                    'flash' => 'Invalid data.',
                    'accountname' => $user->accountname,
                    'email' => $user->email,
                ),
                400
            );
        }

        if (!$user->isThirdParty() && !Hash::check(Input::get('password'), Auth::user()->password)) {
            return Response::json(
                array(
                    'flash' => 'Incorrect password.',
                    'accountname' => $user->accountname,
                    'email' => $user->email,
                ),
                400
            );
        }

        $accountname = Input::get('accountname');
        $email = Input::get('email');

        if (strlen(trim($accountname)) > 0) {
            $user->accountname = $accountname;
        }

        if (strlen(trim($email)) > 0) {
            $user->email = $email;
        }
        $user->save();

        return Response::json(
            array(
                'flash' => 'Your changes have been saved.',
                'accountname' => $user->accountname,
                'email' => $user->email,
            ),
            200
        );
    }

    public function postChangePreferences()
    {
        $user = Auth::user();

        // you can only change name or email, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in first.'), 401);
        }

        $validator = Validator::make(
            Input::all(),
            array(
                'publicfollow' => 'required|boolean',
                'alerts' => 'required|boolean',
            )
        );

        if ($validator->fails()) {
            return Response::json(
            array(
                    'flash' => 'Invalid data',
                    'publicfollow' => $user->publicfollow == 1,
                    'alerts' => $user->alerts == 1,
                ),
            400
            );
        }

        $user->publicfollow = Input::get('publicfollow');
        $user->alerts = Input::get('alerts');
        $user->save();

        return Response::json(
            array(
                'flash' => 'Your changes have been saved.',
                'publicfollow' => $user->publicfollow == 1,
                'alerts' => $user->alerts == 1,
            )
        );
    }

    public function getStats()
    {
        $user = Auth::user();

        // you can only change name or email, if you are logged in
        if (!$user) {
            return Response::json(array('flash' => 'You need to log in first.'), 401);
        }

        // get unseen amount from following controller
        $unseenAmount = (new SeriesController)->getUnseenEpisodes()->getData()->unseenepisodes;

        // find out the number of people who follow less series
        $peopleFollowingLess = User::where('following', '<', $user->following)->count();

        // total number of users
        $userAmount = User::count();

        return Response::json([
            'following' => $user->following,
            'unseen' => $unseenAmount,
            'followmorethan' => round($peopleFollowingLess / $userAmount * 100)
        ]);
    }
}
