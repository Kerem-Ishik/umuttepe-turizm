<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();
        $loggedUserID = session()->get('loggedUser');
        session()->set('userInfo', $userModel->find($loggedUserID));

        return view('home');
    }
}
