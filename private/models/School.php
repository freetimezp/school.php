<?php

class School extends Model
{
    protected $allowedColumns = [
        'school',
        'date'
    ];

    protected $beforeInsert = [
        'make_school_id',
        'make_user_id'
    ];

    public function validate($data) {
        $this->errors = array();

        if(empty($data['school']) || !preg_match('/^[a-zA-Z]+$/', $data['school'])) {
            $this->errors['school'] = "Only letters allowed in school!";
        }

        if(count($this->errors) == 0) {
            return true;
        }

        return false;
    }

    public function make_user_id($data) {
        if(isset($_SESSION['USER']->user_id)) {
            $data['user_id'] = $_SESSION['USER']->user_id;
        }

        return $data;
    }

    public function make_school_id($data) {
        $data['school_id'] = random_string(60);

        return $data;
    }
}