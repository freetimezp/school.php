<?php

class Classes_model extends Model
{
    protected $table = 'classes';

    protected $allowedColumns = [
        'class',
        'date'
    ];

    protected $beforeInsert = [
        'make_class_id',
        'make_school_id',
        'make_user_id'
    ];

    protected $afterSelect = [
        'get_user'
    ];

    public function validate($data) {
        $this->errors = array();
        //[a-z A-Z0-9]  allowed letters, numbers and spaces; if [a-zA-Z] - allowed only letters
        if(empty($data['class']) || !preg_match('/^[a-z A-Z0-9]+$/', $data['class'])) {
            $this->errors['class'] = "Only letters allowed in class!";
        }

        if(count($this->errors) == 0) {
            return true;
        }

        return false;
    }

    public function make_school_id($data) {
        if(isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        }

        return $data;
    }

    public function make_user_id($data) {
        if(isset($_SESSION['USER']->user_id)) {
            $data['user_id'] = $_SESSION['USER']->user_id;
        }

        return $data;
    }

    public function make_class_id($data) {
        $data['class_id'] = random_string(60);

        return $data;
    }

    public function get_user($data) {
        $user = new User();

        foreach ($data as $key => $row) {
            $result = $user->where("user_id", $row->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
        }

        return $data;
    }
}