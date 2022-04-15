<?php

class Profile extends Controller
{
    function index($id = '')
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $id = trim($id == '') ? Auth::getUser_id() : $id;
        $row = $user->first('user_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Profile', 'profile'];
        if($row) {
            $crumbs[] = [$row->firstname, 'profile'];
        }

        $this->view('profile', [
            'row' => $row,
            'crumbs' => $crumbs
        ]);
    }
}