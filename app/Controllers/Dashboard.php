<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('user')) {
            return redirect()->to('/login');
        }

        $user = session()->get('user');
        return view('dashboard', ['user' => $user]);
    }
}
