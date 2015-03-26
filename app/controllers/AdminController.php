<?php namespace EA\controllers;

use BaseController;
use Response;
use Auth;
use Input;
use View;

class AdminController extends BaseController
{
    public function showAdminPage()
    {
    	return View::make(
            'admin',
            array(
            )
        );
    }
}
