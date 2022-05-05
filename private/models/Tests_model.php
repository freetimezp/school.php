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
            $result = $user->where("user_id", $row->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
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
            $query = "SELECT * FROM tests WHERE school_id = :school_id ORDER BY id DESC";
            $arr['school_id'] = $school_id;

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM tests WHERE school_id = :school_id AND test LIKE :find ORDER BY id DESC";
                $arr['find'] = $find;
            }

            $data = $this->query($query, $arr);
        }else{
            $myTable = "class_lecturers";

            $query = "SELECT * FROM $myTable WHERE user_id = :user_id";

            $arr['user_id'] = Auth::getUser_id();

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT tests.test, {$myTable}.* FROM $myTable JOIN tests ON tests.test_id = {$myTable}.test_id WHERE {$myTable}.user_id = :user_id AND {$myTable}.disabled = 0 AND tests.test LIKE :find";
                $arr['find'] = $find;
            }

            //read all tests from the selected classes
            $arr['stud_classes'] = $this->query($query, $arr);
            $data = array();
            if($arr['stud_classes']) {
                foreach ($arr['stud_classes'] as $key => $arow) {
                    $query = "SELECT * FROM tests WHERE class_id = :class_id";
                    $a = $this->query($query, ['class_id' => $arow->class_id]);
                    if(is_array($a)) {
                        $data = array_merge($data, $a);
                    }
                }
            }
        }

        //get all submitted tests
        $to_mark = array();
        if(count($data) > 0) {
            foreach ($data as $key => $arow) {
                $query = "SELECT * FROM answered_tests WHERE test_id = :test_id AND submitted = 1 AND marked = 0 LIMIT 1";
                $a = $this->query($query, ['test_id' => $arow->test_id]);
                if(is_array($a)) {
                    $test_details = $this->first('test_id', $a[0]->test_id);
                    $a[0]->test_details = $test_details;
                    $to_mark = array_merge($to_mark, $a);
                }
            }
        }

        return count($to_mark);
    }
}