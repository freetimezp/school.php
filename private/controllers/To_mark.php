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

        $to_mark = array();

        if(Auth::access('admin')) {
            $query = "SELECT * FROM answered_tests WHERE test_id IN 
                        (SELECT test_id FROM tests WHERE school_id = :school_id) 
                            AND submitted = 1 AND marked = 0 AND year(date) = :school_year ORDER BY id DESC";
            $arr['school_id'] = $school_id;
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM tests WHERE school_id = :school_id AND test LIKE :find 
                            AND year(date) = :school_year ORDER BY id DESC";
                $arr['find'] = $find;
            }

            $to_mark = $tests->query($query, $arr);
        }else{
            $myTable = "class_lecturers";
            $arr['user_id'] = Auth::getUser_id();
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());

            //use nested queries
            $query = "SELECT * FROM answered_tests WHERE test_id IN 
                        (SELECT test_id FROM tests WHERE class_id IN 
                            (SELECT class_id FROM `class_lecturers` WHERE user_id = :user_id)) 
                                AND submitted = 1 AND marked = 0 AND year(date) = :school_year ORDER BY id DESC";

            $to_mark = $tests->query($query, $arr);

            /*
            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT tests.test, {$myTable}.* FROM $myTable JOIN tests ON tests.test_id = {$myTable}.test_id WHERE {$myTable}.user_id = :user_id AND {$myTable}.disabled = 0 AND tests.test LIKE :find";
                $arr['find'] = $find;
            }
            */
        }

        if($to_mark) {
            //get test row data
            foreach ($to_mark as $key => $value) {
                $a = $tests->first('test_id', $value->test_id);
                if($a) {
                    $to_mark[$key]->test_details = $a;
                }
            }
        }

        $this->view('to-mark', [
            'test_rows' => $to_mark,
            'crumbs' => $crumbs
        ]);
    }
}


