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