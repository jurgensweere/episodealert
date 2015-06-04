<?php namespace EA\controllers;

use BaseController;
use Response;
use Auth;
use Input;
use EA\models\User;

class UserController extends BaseController
{
    public function getUsers()
    {
        $users = User::orderBy('id', 'ASC')
            ->paginate(15);

        return Response::json($users);
    }
}
