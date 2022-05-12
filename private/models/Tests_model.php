<?php

class Tests_model extends Model
{
    protected $table = 'tests';

    protected $allowedColumns = [
        'test',
        'date',
        'class_id',
        'description',
        'disabled'
    ];

    protected $beforeInsert = [
        'make_school_id',
        'make_user_id',
        'make_test_id'
    ];

    protected $afterSelect = [
        'get_user',
        'get_class'
    ];

    public function validate($data) {
        $this->errors = array();
        //[a-z A-Z0-9]  allowed letters, numbers and spaces; if [a-zA-Z] - allowed only letters
        if(empty($data['test']) || !preg_match('/^[a-z A-Z0-9]+$/', $data['test'])) {
            $this->errors['test'] = "Only letters allowed in test!";
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

    public function make_test_id($data) {
        $data['test_id'] = random_string(60);

        return $data;
    }

    public function get_user($data) {
        $user = new User();

        foreach ($data as $key => $row) {
            if(!empty($row->user_id)) {
                $result = $user->where("user_id", $row->user_id);
                $data[$key]->user = is_array($result) ? $result[0] : false;
            }
        }

        return $data;
    }

    public function get_class($data) {
        $class = new Classes_model();

        foreach ($data as $key => $row) {
            if(!empty($row->class_id)) {
                $result = $class->where("class_id", $row->class_id);
                $data[$key]->class = is_array($result) ? $result[0] : false;
            }
        }

        return $data;
    }

    public function get_answered_test($test_id, $user_id) {
        $db = new Database();
        $arr = [
            'test_id' => $test_id,
            'user_id' => $user_id
        ];
        $res = $db->query("SELECT * FROM answered_tests WHERE test_id = :test_id AND user_id = :user_id LIMIT 1", $arr);

        if(is_array($res)) {
            return $res[0];
        }

        return false;
    }

    public function get_to_mark_count() {
        $school_id = Auth::getSchool_id();

        if(Auth::access('admin')) {
            $query = "SELECT * FROM answered_tests WHERE test_id IN 
                        (SELECT test_id FROM tests WHERE school_id = :school_id) AND submitted = 1 AND marked = 0 ORDER BY id DESC";
            $arr['school_id'] = Auth::getSchool_id();

            $to_mark = $this->query($query, $arr);
        }else{
            $myTable = "class_lecturers";
            $arr['user_id'] = Auth::getUser_id();

            //use nested queries
            $query = "SELECT * FROM answered_tests WHERE test_id IN 
                        (SELECT test_id FROM tests WHERE class_id IN 
                            (SELECT class_id FROM `class_lecturers` WHERE user_id = :user_id)) 
                                AND submitted = 1 AND marked = 0 ORDER BY id DESC";

            $to_mark = $this->query($query, $arr);
        }

        return count($to_mark);
    }
}