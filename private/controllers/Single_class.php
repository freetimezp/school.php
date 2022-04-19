<?php

class Single_class extends Controller
{
    public function index($id = '')
    {
        $errors = array();

        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if($row) {
            $crumbs[] = [$row->class, ''];
        }

        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';

        $lect = new Lecturers_model();
        $results = false;

        if ($page_tab == 'lecturers') {
            $query = "SELECT * FROM class_lecturers WHERE class_id = :class_id AND disabled = 0 ORDER BY id DESC";
            $lecturers = $lect->query($query, ['class_id' => $id]);
            $data['lecturers'] = $lecturers;
        }elseif ($page_tab == 'students') {
            $query = "SELECT * FROM class_students WHERE class_id = :class_id AND disabled = 0 ORDER BY id DESC";
            $students = $lect->query($query, ['class_id' => $id]);
            $data['students'] = $students;
        }

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;

        $this->view('single-class', $data);
    }

    public function lectureradd($id = '') {
        $errors = array();

        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if($row) {
            $crumbs[] = [$row->class, ''];
        }

        $page_tab = 'lecturer-add';

        $lect = new Lecturers_model();
        $results = false;

        if(count($_POST) > 0) {
            if(isset($_POST['search'])) {
                //find lecturer
                if(!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = "%" . trim($_POST['name']) . "%";
                    $query = "SELECT * FROM users WHERE (firstname LIKE :fname OR lastname LIKE :lname) AND rank = 'lecturer' LIMIT 10 ";
                    $results = $user->query("$query", [
                        'fname' => $name,
                        'lname' => $name
                    ]);
                }else {
                    $errors[] = "Please type a name to find!";

                }
            }elseif(isset($_POST['selected'])) {
                //add lecturer
                $query = "SELECT id,disabled FROM class_lecturers WHERE user_id = :user_id AND class_id = :class_id LIMIT 1";

                if(!$check = $lect->query($query, [
                    'user_id' => $_POST['selected'],
                    'class_id' => $id
                ])) {
                    $arr = array();
                    $arr['user_id'] = $_POST['selected'];
                    $arr['class_id'] = $id;
                    $arr['disabled'] = 0;
                    $arr['date'] = date("Y-m-d H:i:s");

                    $lect->insert($arr);

                    $this->redirect('single_class/' . $id . '?tab=lecturers');
                }else{
                    //check if user is active
                    if(isset($check[0]->disabled)) {
                        if($check[0]->disabled == 1) {
                            $arr = array();
                            $arr['disabled'] = 0;

                            $lect->update($check[0]->id, $arr);

                            $this->redirect('single_class/' . $id . '?tab=lecturers');
                        }else{
                            $errors[] = "That lecturer already belongs to this class";
                        }
                    }else{
                        $errors[] = "That lecturer has error on disabled item";
                    }
                }
            }
        }

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;

        $this->view('single-class', $data);
    }

    public function lecturerremove($id = '') {
        $errors = array();

        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if($row) {
            $crumbs[] = [$row->class, ''];
        }

        $page_tab = 'lecturer-remove';

        $lect = new Lecturers_model();
        $results = false;

        if(count($_POST) > 0) {
            if(isset($_POST['search'])) {
                //find lecturer
                if(!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = "%" . trim($_POST['name']) . "%";
                    $query = "SELECT * FROM users WHERE (firstname LIKE :fname OR lastname LIKE :lname) AND rank = 'lecturer' LIMIT 10 ";
                    $results = $user->query("$query", [
                        'fname' => $name,
                        'lname' => $name
                    ]);
                }else {
                    $errors[] = "Please type a name to find!";

                }
            }elseif(isset($_POST['selected'])) {
                //remove lecturer
                $query = "SELECT id FROM class_lecturers WHERE user_id = :user_id AND class_id = :class_id AND disabled = 0 LIMIT 1";

                if($row = $lect->query($query, [
                    'user_id' => $_POST['selected'],
                    'class_id' => $id
                ])) {
                    $arr = array();
                    $arr['disabled'] = 1;

                    $lect->update($row[0]->id, $arr);

                    $this->redirect('single_class/' . $id . '?tab=lecturers');
                }else{
                    $errors[] = "That lecturer was not found in this class!";
                }
            }
        }

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;

        $this->view('single-class', $data);
    }

    public function studentadd($id = '') {
        $errors = array();

        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if($row) {
            $crumbs[] = [$row->class, ''];
        }

        $page_tab = 'student-add';

        $stud = new Students_model();
        $results = false;

        if(count($_POST) > 0) {
            if(isset($_POST['search'])) {
                //find student
                if(!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = "%" . trim($_POST['name']) . "%";
                    $query = "SELECT * FROM users WHERE (firstname LIKE :fname OR lastname LIKE :lname) AND rank = 'student' LIMIT 10 ";
                    $results = $user->query("$query", [
                        'fname' => $name,
                        'lname' => $name
                    ]);
                }else {
                    $errors[] = "Please type a name to find!";

                }
            }elseif(isset($_POST['selected'])) {
                //add student
                $query = "SELECT id, disabled FROM class_students WHERE user_id = :user_id AND class_id = :class_id LIMIT 1";

                if(!$check = $stud->query($query, [
                    'user_id' => $_POST['selected'],
                    'class_id' => $id
                ])) {
                    $arr = array();
                    $arr['user_id'] = $_POST['selected'];
                    $arr['class_id'] = $id;
                    $arr['disabled'] = 0;
                    $arr['date'] = date("Y-m-d H:i:s");

                    $stud->insert($arr);

                    $this->redirect('single_class/' . $id . '?tab=students');
                }else{
                    //check if user is active
                    if(isset($check[0]->disabled)) {
                        if($check[0]->disabled == 1) {
                            $arr = array();
                            $arr['disabled'] = 0;

                            $stud->update($check[0]->id, $arr);

                            $this->redirect('single_class/' . $id . '?tab=students');
                        }else{
                            $errors[] = "That student already belongs to this class";
                        }
                    }else{
                        $errors[] = "That student has error on disabled item";
                    }                }
            }
        }

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;

        $this->view('single-class', $data);
    }

    public function studentremove($id = '') {
        $errors = array();

        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if($row) {
            $crumbs[] = [$row->class, ''];
        }

        $page_tab = 'student-remove';

        $stud = new Students_model();
        $results = false;

        if(count($_POST) > 0) {
            if(isset($_POST['search'])) {
                //find lecturer
                if(!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = "%" . trim($_POST['name']) . "%";
                    $query = "SELECT * FROM users WHERE (firstname LIKE :fname OR lastname LIKE :lname) AND rank = 'student' LIMIT 10 ";
                    $results = $user->query("$query", [
                        'fname' => $name,
                        'lname' => $name
                    ]);
                }else {
                    $errors[] = "Please type a name to find!";
                }
            }elseif(isset($_POST['selected'])) {
                //remove lecturer
                $query = "SELECT id FROM class_students WHERE user_id = :user_id AND class_id = :class_id AND disabled = 0 LIMIT 1";

                if($row = $stud->query($query, [
                    'user_id' => $_POST['selected'],
                    'class_id' => $id
                ])) {
                    $arr = array();
                    $arr['disabled'] = 1;

                    $stud->update($row[0]->id, $arr);

                    $this->redirect('single_class/' . $id . '?tab=students');
                }else{
                    $errors[] = "That student was not found in this class!";
                }
            }
        }

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;

        $this->view('single-class', $data);
    }
}