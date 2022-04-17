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

        $query = "SELECT * FROM users WHERE school_id = :school_id AND rank IN ('student') ORDER BY id DESC";
        $arr['school_id'] = $school_id;

        if(isset($_GET['find'])) {
            $find = '%' . $_GET['find'] . '%';
            $query = "SELECT * FROM users WHERE school_id = :school_id AND rank IN ('student') AND (firstname LIKE :find OR lastname LIKE :find)  ORDER BY id DESC";
            $arr['find'] = $find;
        }

        $data = $user->query($query, $arr);

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