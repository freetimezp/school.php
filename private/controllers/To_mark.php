<?php

class To_mark extends Controller
{
    function index()
    {
        if(!Auth::access('lecturer')) {
            $this->redirect('access-denied');
        }

        $tests = new Tests_model();
        $school_id = Auth::getSchool_id();

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['To_mark', 'to_mark'];

        if(Auth::access('admin')) {
            $query = "SELECT * FROM tests WHERE school_id = :school_id ORDER BY id DESC";
            $arr['school_id'] = $school_id;

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM tests WHERE school_id = :school_id AND test LIKE :find ORDER BY id DESC";
                $arr['find'] = $find;
            }

            $data = $tests->query($query, $arr);
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
            $arr['stud_classes'] = $tests->query($query, $arr);
            $data = array();
            if($arr['stud_classes']) {
                foreach ($arr['stud_classes'] as $key => $arow) {
                    $query = "SELECT * FROM tests WHERE class_id = :class_id";
                    $a = $tests->query($query, ['class_id' => $arow->class_id]);
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
                $a = $tests->query($query, ['test_id' => $arow->test_id]);
                if(is_array($a)) {
                    $test_details = $tests->first('test_id', $a[0]->test_id);
                    $a[0]->test_details = $test_details;
                    $to_mark = array_merge($to_mark, $a);
                }
            }
        }

        $this->view('to-mark', [
            'test_rows' => $to_mark,
            'crumbs' => $crumbs
        ]);
    }
}


