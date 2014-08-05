<?php namespace EA\controllers;

use BaseController;
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
}
