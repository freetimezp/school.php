<?php

class Home extends Controller
{
    function index()
    {
        $user = new User();

        //$data = $db->query("SELECT * FROM users");

        $arr['firstname'] = 'mary3';
        $arr['lastname'] = 'sith2';;
        $arr['date'] = '2022-03-08 00:00:02';;
//        $arr['user_id'] = 'adsas';;
//        $arr['gender'] = 'female';;
//        $arr['school_id'] = 'fghgff';;
//        $arr['rank'] = 'student';;

        $user->update(3, $arr);


        $data = $user->findAll();
        $this->view('home', ['rows' => $data]);
    }
}

