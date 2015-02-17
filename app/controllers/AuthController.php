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
use Config;
use Google_Client;
use Google_Service_Oauth2;
use Google_Http_Request;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Session;

class AuthController extends BaseController
{
    public function register() {

        $usernameCheck  = User::where('username', Input::get('username'))->count();

        if (!$usernameCheck) {
            $user = User::create(
                array(
                    'accountname' => Input::get('username'),
                    'username' => Input::get('username'),
                    'email' => Input::get('email'),
                    'password' => Hash::make(Input::get('password')),
                    'role' => User::ROLE_MEMBER,
                    'publicfollow' => 0,
                )
            );

            return Response::json(array('flash' => 'Thanks for registering'));          
        } else {
            return Response::json(array('flash' => 'Username allready in use'), 500);
        }

    }

    public function login() {
        if (Auth::attempt(array('username' => Input::json('username'), 'password' => Input::json('password'))))
        {
            return Response::json(array('id' => Auth::user()->id,
                    'username' => Auth::user()->accountname,
                    'email' => Auth::user()->email,
                    'thirdparty' => Auth::user()->isThirdParty()));
        } else {
             return Response::json(array('flash' => 'Invalid username or password'), 500);
        }
    }

    public function logout() {
        Auth::logout();
        return Response::json(array('flash' => 'Loggout Out!'));
    }

    /*
     * returns user if there is a session
     */

    public function checkAuth() {
        if (Auth::user()) {
            return Response::json(array('id' => Auth::user()->id,
                    'username' => Auth::user()->accountname,
                    'email' => Auth::user()->email,
                    'thirdparty' => Auth::user()->isThirdParty()));
        } else {
            return Response::json(array('flash' => 'Not authorized'), 500);
        }
    }

    public function logoutGoogleOAuth()
    {
        //unset($_SESSION['access_token']);
        return Redirect::to(filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }

    public function callbackGoogleOAuth()
    {
        if (Input::get('state') != (Session::get('state'))) {
            return Response::json(array('flash' => 'Invalid state'), 401);
        }

        $authResult = Input::get('authResult');
        //$gPlusId = $request->get['gplus_id']; // ???
        $client = new Google_Client();
        $client->setRedirectUri('postmessage');
        $client->setAuthConfigFile(app_path().'/config/client_secret.json');
        $client->authenticate($authResult['code']);

        $token = $client->getAccessToken();
        $gso = new Google_Service_Oauth2($client);
        $me = $gso->userinfo->get();

        // check if this user exists, otherwise create
        $user = User::where('oauthprovider', '=', 'google')
            ->where('oauthid', '=', $me->id)
            ->first();
        if (!$user) {
            // Create User
            $user = User::create(
                array(
                    'accountname' => $me->name,
                    'oauthprovider' => 'google',
                    'oauthid' => $me->id,
                    'username' => '',
                    'email' => $me->email,
                    'password' => '',
                    'role' => User::ROLE_MEMBER,
                    'publicfollow' => 0,
                )
            );
        }
      
        Auth::login($user);

        return Response::json(array('id' => Auth::user()->id,
                    'username' => Auth::user()->accountname,
                    'email' => Auth::user()->email));
    }

    public function callbackFacebookOAuth()
    {
        if (Input::get('state') != (Session::get('state'))) {
            return Response::json(array('flash' => 'Invalid state'), 401);
        }

        FacebookSession::setDefaultApplication(Config::get('app.facebook.appid'), Config::get('app.facebook.appsecret'));

        $authResult = Input::get('authResult');
        $session = new FacebookSession($authResult['accessToken']);
        $me = (new FacebookRequest(
            $session, 'GET', '/me'
        ))->execute()->getGraphObject(GraphUser::className());

        // check if this user exists, otherwise create
        $user = User::where('oauthprovider', '=', 'facebook')
            ->where('oauthid', '=', $me->getId())
            ->first();
        if (!$user) {
            // Create User
            $user = User::create(
                array(
                    'accountname' => $me->getName(),
                    'oauthprovider' => 'google',
                    'oauthid' => $me->getId(),
                    'username' => '',
                    'email' => $me->getEmail(),
                    'password' => '',
                    'role' => User::ROLE_MEMBER,
                    'publicfollow' => 0,
                )
            );
        }
        
        Auth::login($user);

        return Response::json(array('id' => Auth::user()->id,
                    'username' => Auth::user()->accountname,
                    'email' => Auth::user()->email));
    }
}