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

        $limit = 4;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $query = "SELECT * FROM users WHERE school_id = :school_id AND rank NOT IN ('student') ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $arr['school_id'] = $school_id;

        if(isset($_GET['find'])) {
            $find = '%' . $_GET['find'] . '%';
            $query = "SELECT * FROM users WHERE school_id = :school_id AND rank NOT IN ('student') 
                        AND (firstname LIKE :find OR lastname LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $arr['find'] = $find;
        }

        $data = $user->query($query, $arr);

        if(Auth::access('admin')) {
            $this->view('users', [
                'rows' => $data,
                'crumbs' => $crumbs,
                'pager' => $pager
            ]);
        }else{
            $this->view('access-denied');
        }
    }
}