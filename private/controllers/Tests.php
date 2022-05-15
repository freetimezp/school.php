<?php

class Tests extends Controller
{
    public function index() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();
        $school_id = Auth::getSchool_id();

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];

        if(Auth::access('admin')) {
            $query = "SELECT * FROM tests WHERE school_id = :school_id AND year(date) = :school_year ORDER BY id DESC";
            $arr['school_id'] = $school_id;
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM tests WHERE school_id = :school_id AND test LIKE :find AND year(date) = :school_year ORDER BY id DESC";
                $arr['find'] = $find;
            }

            $data = $tests->query($query, $arr);
        }else{
            $test = new Tests_model();
            $myTable = "class_students";
            $disabled = " disabled = 0 AND";
            $data = array();

            if(Auth::getRank() == 'lecturer') {
                $myTable = "class_lecturers";
                $disabled = "";
            }

            //use nested queries
            $query = "SELECT * FROM tests WHERE $disabled class_id IN 
                        (SELECT class_id FROM $myTable WHERE $disabled user_id = :user_id) AND year(date) = :school_year
                            ORDER BY id DESC";
            $arr['user_id'] = Auth::getUser_id();
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());

            //search
            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM tests WHERE $disabled class_id IN 
                        (SELECT class_id FROM $myTable WHERE $disabled user_id = :user_id)
                            AND test LIKE :find AND year(date) = :school_year ORDER BY id DESC";
                $arr['find'] = $find;
            }

            $data = $test->query($query, $arr);
        }

        $this->view('tests', [
            'test_rows' => $data,
            'unsubmitted' => get_unsubmitted_test_rows(),
            'crumbs' => $crumbs
        ]);
    }
}

