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

        if($this->where('email', $data['email'])) {
            $this->errors['email'] = "Email is already in use!";
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
        $data['user_id'] = strtolower($data['firstname'] . '.' . $data['lastname']);

        while($this->where('user_id', $data['user_id'])) {
            $data['user-id'] .= rand(10, 9999);
        }

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

}