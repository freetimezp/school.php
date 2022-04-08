<?php

class Users extends Controller
{
    function index()
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $school_id = Auth::getSchool_id();

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Staff', 'users'];

        $data = $user->query("SELECT * FROM users WHERE school_id = :school_id AND rank NOT IN ('student')", ['school_id' => $school_id]);
        $this->view('users', [
            'rows' => $data,
            'crumbs' => $crumbs
        ]);
    }
}