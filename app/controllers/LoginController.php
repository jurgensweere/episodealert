<?php namespace EA\controllers;

use Auth;
use EA\models\User;
use BaseController;
use Input;
use Redirect;
use Validator;
use View;

class LoginController extends BaseController
{
    public function showLogin()
    {
        return View::make(
            'login',
            array(
                'title' => 'Login',
            )
        );
    }

    public function showRegister()
    {
        return View::make(
            'register',
            array(
                'title' => 'Register',
            )
        );
    }

    public function submitRegister()
    {
        // Validate input.
        $validator = Validator::make(
            Input::get(),
            array(
                'username' => 'required|alpha_num|max:100|unique:user,accountname',
                'email' => 'required|email|unique:user',
                'password' => 'required|confirmed|min:8',
            )
        );
        if ($validator->fails()) {
            return Redirect::to('login/register')->withErrors($validator)->withInput();
        }

        // Seems good, create the user.
        $user = User::create(
            array(
                'accountname' => Input::get('username'),
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'password' => md5(Input::get('password')),
                'role' => User::ROLE_MEMBER,
                'publicfollow' => 0,
            )
        );

        // Log in
        Auth::login($user);
    }

    public function showPasswordReset()
    {
        return View::make(
            'passwordreset',
            array(
                'title' => 'Reset Password',
            )
        );
    }

    public function submitPasswordReset()
    {
        // Validate input.
        $validator = Validator::make(
            Input::get(),
            array(
                'email' => 'required|email|exists:user'
            )
        );
        if ($validator->fails()) {
            return Redirect::to('login/passwordreset')->withErrors($validator);
        }
    }
}
