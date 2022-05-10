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
            $query = "SELECT * FROM tests WHERE school_id = :school_id ORDER BY id DESC";
            $arr['school_id'] = $school_id;

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM tests WHERE school_id = :school_id AND test LIKE :find ORDER BY id DESC";
                $arr['find'] = $find;
            }

            $data = $tests->query($query, $arr);
        }else{
            $test = new Tests_model();
            $myTable = "class_students";
            $disabled = " disabled = 0 AND";

            if(Auth::getRank() == 'lecturer') {
                $myTable = "class_lecturers";
                $disabled = "";
            }

            $query = "SELECT * FROM $myTable WHERE $disabled user_id = :user_id ORDER BY id DESC";

            $arr['user_id'] = Auth::getUser_id();

            $arr['stud_classes'] = $test->query($query, $arr);

            $data = array();
            $arr2 = array();

            if($arr['stud_classes']) {
                foreach ($arr['stud_classes'] as $key => $arow) {
                    $query = "SELECT * FROM tests WHERE $disabled class_id = :class_id ORDER BY id DESC";
                    $arr2['class_id'] = $arow->class_id;

                    //search
                    if(isset($_GET['find'])) {
                        $find = '%' . $_GET['find'] . '%';
                        $query = "SELECT * FROM tests WHERE $disabled class_id = :class_id AND test LIKE :find";
                        $arr2['find'] = $find;
                    }

                    $a = $tests->query($query, $arr2);
                    if(is_array($a)) {
                        $data = array_merge($data, $a);
                    }
                }
            }
        }

        $this->view('tests', [
            'test_rows' => $data,
            'crumbs' => $crumbs
        ]);
    }
}
