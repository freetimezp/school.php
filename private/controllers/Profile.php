<?php

class Profile extends Controller
{
    function index($id = '')
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $data = array();

        $user = new User();
        $id = trim($id == '') ? Auth::getUser_id() : $id;
        $row = $user->first('user_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Profile', 'profile'];
        if($row) {
            $crumbs[] = [$row->firstname, 'profile'];
        }

        //get more information depending on tab
        $data['page_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'info';
        $data['row'] = $row;
        $data['crumbs'] = $crumbs;

        $this->view('profile', $data);
    }
}