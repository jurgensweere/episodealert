<?php namespace EA\controllers;

use BaseController;
use Response;
use Auth;
use Input;
use Session;
use EA\models\User;

class UserController extends BaseController
{
    public function getUser(User $user)
    {
        return Response::json($user);
    }

    public function getUsers()
    {
        $query = Input::get('query');
        $users = User::orderBy('id', 'ASC');
        if (!empty($query)) {
            $users = $users->where('accountname', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%');
        }

        $users = $users
            ->paginate(15);

        return Response::json($users);
    }

    public function getAssumeDirectControl(User $user)
    {
        // Store the admin in session, to allow going back
        Session::put('ADMIN_HERP', Auth::user());
        // First we implement ez mode
        Auth::login($user);

        return Response::json($user);
    }
}
