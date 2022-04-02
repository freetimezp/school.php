<?php

class Signup extends Controller
{
    function index()
    {
        $errors = array();

        if(count($_POST) > 0) {
            $user = new User();

            if($user->validate($_POST)) {
                $arr['firstname'] = $_POST['firstname'];
                $arr['lastname'] = $_POST['lastname'];
                $arr['email'] = $_POST['email'];
                $arr['date'] = date("Y-m-d H:i:s");
                $arr['user_id'] = '';
                $arr['gender'] = $_POST['gender'];
                $arr['school_id'] = '';
                $arr['rank'] = $_POST['rank'];
                $arr['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $user->insert($arr);
                $this->redirect('login');
            }else{
                $errors = $user->errors;
            }
        }

        $this->view('signup', ['errors' => $errors]);
    }
}
