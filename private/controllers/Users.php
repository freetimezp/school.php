<?php

class Users extends Controller
{
    function index()
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $data = $user->findAll();
        $this->view('users', ['rows' => $data]);
    }
}