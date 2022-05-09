<?php

class Classes extends Controller
{
    public function index() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];

        $school_id = Auth::getSchool_id();

        if(Auth::access('admin')) {
            $query = "SELECT * FROM classes WHERE school_id = :school_id ORDER BY id DESC";
            $arr['school_id'] = $school_id;

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM classes WHERE school_id = :school_id AND class LIKE :find ORDER BY id DESC";
                $arr['find'] = $find;
            }

            $data = $classes->query($query, $arr);
        }else{
            $class = new Classes_model();
            $myTable = "class_students";

            if(Auth::getRank() == 'lecturer') {
                $myTable = "class_lecturers";
            }

            $query = "SELECT * FROM $myTable WHERE user_id = :user_id AND disabled = 0";

            $arr['user_id'] = Auth::getUser_id();

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT classes.class, {$myTable}.* FROM $myTable JOIN classes ON classes.class_id = {$myTable}.class_id WHERE {$myTable}.user_id = :user_id AND {$myTable}.disabled = 0 AND classes.class LIKE :find";
                $arr['find'] = $find;
            }

            $arr['stud_classes'] = $class->query($query, $arr);

            //get class ids from classes that dont have members
            $classes_i_own = $class->where('user_id', Auth::getUser_id());
            if($classes_i_own && $arr['stud_classes']) {
                $arr['stud_classes'] = array_merge($classes_i_own, $arr['stud_classes']);
            }

            $data = array();
            $all_classes = array();
            if($arr['stud_classes']) {
                //choose all class_id from array
                //dont work---->>>> $all_classes = array_column($arr['stud_classes'], 'class_id');
                foreach ($arr['stud_classes'] as $key => $value) {
                    $all_classes[] = $value->class_id;
                }
                
                //delete duplicate from array
                $all_classes = array_unique($all_classes);
                foreach ($all_classes as $class_id) {
                    $data[] = $class->first('class_id', $class_id);
                }
            }
        }

        $this->view('classes', [
            'rows' => $data,
            'crumbs' => $crumbs
        ]);
    }

    public function add() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        if(count($_POST) > 0) {
            $classes = new Classes_model();

            if($classes->validate($_POST)) {
                $_POST['date'] = date("Y-m-d H:i:s");

                $classes->insert($_POST);
                $this->redirect('classes');
            }else{
                $errors = $classes->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        $crumbs[] = ['Add', 'classes/add'];

        $this->view('classes.add', [
            'errors' => $errors,
            'crumbs' => $crumbs
        ]);
    }

    public function edit($id = null) {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        $classes = new Classes_model();
        $row = $classes->where('id', $id);

        if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row)) {
            if($classes->validate($_POST)) {
                $classes->update($id, $_POST);
                $this->redirect('classes');
            }else{
                $errors = $classes->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        $crumbs[] = ['Edit', 'classes/edit'];

        if(Auth::access('lecturer') && Auth::i_own_content($row)) {
            $this->view('classes.edit', [
                'row' => $row,
                'errors' => $errors,
                'crumbs' => $crumbs
            ]);
        }else{
            $this->view('access-denied');
        }
    }

    public function delete($id = null) {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        $classes = new Classes_model();

        $row = $classes->where('id', $id);

        if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row)) {
            $classes->delete($id);
            $this->redirect('classes');
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        $crumbs[] = ['Delete', 'classes/delete'];

        if(Auth::access('lecturer') && Auth::i_own_content($row)) {
            $this->view('classes.delete', [
                'row' => $row,
                'crumbs' => $crumbs
            ]);
        }else{
            $this->view('access-denied');
        }
    }
}
