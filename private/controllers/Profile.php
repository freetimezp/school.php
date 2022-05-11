<?php

class Profile extends Controller
{
    function index($id = '')
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $data = array();

        $user = new User();
        $id = trim($id == '') ? Auth::getUser_id() : $id;
        $row = $user->first('user_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Profile', 'profile'];
        if($row) {
            $crumbs[] = [$row->firstname, 'profile'];
        }

        //get more information depending on tab
        $data['page_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'info';

        if($data['page_tab'] == 'classes' && $row) {
            $class = new Classes_model();

            $myTable = "class_students";

            if($row->rank == 'lecturer') {
                $myTable = "class_lecturers";
            }

            $query = "SELECT * FROM $myTable WHERE user_id = :user_id AND disabled = 0";
            $data['stud_classes'] = $class->query($query, ['user_id' => $id]);

            $data['student_classes'] = array();

            if($data['stud_classes']) {
                foreach ($data['stud_classes'] as $key => $arow) {
                    $data['student_classes'][] = $class->first('class_id', $arow->class_id);
                }
            }
        }elseif($data['page_tab'] == 'tests' && $row) {
            $class = new Classes_model();
            $disabled = " disabled = 0 AND ";
            $myTable = "class_students";

            if($row->rank != 'student') {
                if($row->rank == 'lecturer') {
                    $myTable = "class_lecturers";
                    $disabled = "";
                }

                $tests_model = new Tests_model();
                $query = "SELECT * FROM tests WHERE $disabled class_id IN 
                            (SELECT class_id FROM $myTable WHERE $disabled user_id = :user_id) ORDER BY id DESC";
                $arr['user_id'] = $id;

                //search
                if(isset($_GET['find'])) {
                    $find = '%' . $_GET['find'] . '%';
                    $query = "SELECT * FROM tests WHERE $disabled class_id IN 
                                (SELECT class_id FROM $myTable WHERE $disabled user_id = :user_id) 
                                    AND test LIKE :find ORDER BY id DESC";
                    $arr['find'] = $find;
                }

                $data['test_rows'] = $tests_model->query($query, $arr);

                /*
                $query = "SELECT * FROM $myTable WHERE $disabled user_id = :user_id";
                $data['stud_classes'] = $class->query($query, ['user_id' => $id]);

                $data['student_classes'] = array();

                if($data['stud_classes']) {
                    foreach ($data['stud_classes'] as $key => $arow) {
                        $data['student_classes'][] = $class->first('class_id', $arow->class_id);
                    }
                }

                //collect class id's
                $class_ids = [];
                foreach ($data['student_classes'] as $key => $class_row) {
                    $class_ids[] = $class_row->class_id;
                }

                $id_str = "'" . implode("','", $class_ids) . "'";
                $query = "SELECT * FROM tests WHERE $disabled class_id IN ($id_str)";

                $tests_model = new Tests_model();
                $tests = $tests_model->query($query);
                */

                //$data['test_rows'] = $tests;
            }else {
                //get all submitted tests
                $marked = array();
                $tests = new Tests_model();
                $query = "SELECT * FROM answered_tests WHERE user_id = :user_id AND submitted = 1 AND marked = 1";
                $answered_tests = $tests->query($query, ['user_id' => $id]);
                if (is_array($answered_tests)) {
                    foreach ($answered_tests as $key => $item) {
                        $test_details = $tests->first('test_id', $answered_tests[$key]->test_id);
                        $answered_tests[$key]->test_details = $test_details;
                    }
                }
                $data['test_rows'] = $answered_tests;
            }
        }

        $data['row'] = $row;
        $data['crumbs'] = $crumbs;

        if(Auth::access('reception') || Auth::i_own_content($row)) {
            $this->view('profile', $data);
        }else{
            $this->view('access-denied');
        }
    }

    function edit($id = '') {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $data = array();
        $errors = array();

        $user = new User();
        $id = trim($id == '') ? Auth::getUser_id() : $id;

        if(count($_POST) > 0 && Auth::access('reception')) {
            if(trim($_POST['password']) == "") {
                unset($_POST['password']);
                unset($_POST['password2']);
            }

            if($user->validate($_POST, $id)) {
                //check for uploaded files
                if($myImage = upload_image($_FILES)) {
                    $_POST['image'] = $myImage;
                }

                if($_POST['rank'] == 'super_admin' && $_SESSION['USER']->rank != 'super_admin') {
                   $_POST['rank'] = 'admin';
                }

                $myRow = $user->first('user_id', $id);
                if(is_object($myRow)) {
                    $user->update($myRow->id, $_POST);
                }

                $redirect = 'profile/edit/' . $id;
                $this->redirect($redirect);
            }else{
                $errors = $user->errors;
            }
        }

        $row = $user->first('user_id', $id);

        $data['row'] = $row;
        $data['errors'] = $errors;

        if(Auth::access('reception') || Auth::i_own_content($row)){
            $this->view('profile-edit', $data);
        }else{
            $this->view('access-denied');
        }
    }
}