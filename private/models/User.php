<?php

class User extends Model
{
    protected $allowedColumns = [
        'firstname',
        'lastname',
        'email',
        'date',
        'gender',
        'rank',
        'password'
    ];

    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password'
    ];

    public function validate($data) {
        $this->errors = array();

        if(empty($data['firstname']) || !preg_match('/^[a-zA-Z]+$/', $data['firstname'])) {
            $this->errors['firstname'] = "Only letters allowed in first name!";
        }

        if(empty($data['lastname']) || !preg_match('/^[a-zA-Z]+$/', $data['lastname'])) {
            $this->errors['lastname'] = "Only letters allowed in last name!";
        }

        if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid!";
        }

        $genders = ['female', 'male'];
        if(empty($data['gender']) || !in_array($data['gender'], $genders)) {
            $this->errors['gender'] = "Gender is not valid!";
        }

        $ranks = ['student', 'reception', 'lecturer', 'admin', 'super_admin'];
        if(empty($data['rank']) || !in_array($data['rank'], $ranks)) {
            $this->errors['rank'] = "Rank is not valid!";
        }

        if(empty($data['password']) || $data['password'] != $data['password2']) {
            $this->errors['password'] = "The passwords do not match!";
        }

        if(strlen($data['password']) < 10) {
            $this->errors['password'] = "Password must be at least 10 symbols long!";
        }

        if(count($this->errors) == 0) {
            return true;
        }

        return false;
    }

    public function make_user_id($data) {
        $data['user_id'] = $this->random_string(60);

        return $data;
    }

    public function make_school_id($data) {
        if(isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        }

        return $data;
    }

    public function hash_password($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $data;
    }

    private function random_string($length) {
        $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $text = '';
        for ($x = 0; $x < $length; $x++) {
            $random = rand(0, 61);
            $text .= $array[$random];
        }
        return $text;
    }
}