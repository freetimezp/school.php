<?php

class Home extends Controller
{
    function index()
    {
        $user = $this->load_model('User');

        //$data = $db->query("SELECT * FROM users");
        $data = $user->findAll();
        $this->view('home', ['rows' => $data]);
    }
}

