<?php

class Students extends Controller
{
    function index()
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $school_id = Auth::getSchool_id();

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Students', 'students'];

        $data = $user->query("SELECT * FROM users WHERE school_id = :school_id AND rank IN ('student') ORDER BY id DESC", ['school_id' => $school_id]);

        if(Auth::access('reception')) {
            $this->view('students', [
                'rows' => $data,
                'crumbs' => $crumbs
            ]);
        }else{
            $this->view('access-denied');
        }
    }
}