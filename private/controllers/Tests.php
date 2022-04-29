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

            if(Auth::getRank() == 'lecturer') {
                $myTable = "class_lecturers";
            }

            $query = "SELECT * FROM $myTable WHERE user_id = :user_id AND disabled = 0";

            $arr['user_id'] = Auth::getUser_id();

            if(isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT tests.test, {$myTable}.* FROM $myTable JOIN tests ON tests.test_id = {$myTable}.test_id WHERE {$myTable}.user_id = :user_id AND {$myTable}.disabled = 0 AND tests.test LIKE :find";
                $arr['find'] = $find;
            }

            $arr['stud_classes'] = $test->query($query, $arr);

            $data = array();

            if($arr['stud_classes']) {
                foreach ($arr['stud_classes'] as $key => $arow) {
                    $a = $test->where('class_id', $arow->class_id);

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

    public function add() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        if(count($_POST) > 0) {
            $tests = new Tests_model();

            if($tests->validate($_POST)) {
                $_POST['date'] = date("Y-m-d H:i:s");

                $tests->insert($_POST);
                $this->redirect('tests');
            }else{
                $errors = $tests->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        $crumbs[] = ['Add', 'tests/add'];

        $this->view('tests.add', [
            'errors' => $errors,
            'crumbs' => $crumbs
        ]);
    }

    public function edit($id = null) {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        $tests = new Tests_model();
        $row = $tests->where('id', $id);

        if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row)) {
            if($tests->validate($_POST)) {
                $tests->update($id, $_POST);
                $this->redirect('tests');
            }else{
                $errors = $tests->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        $crumbs[] = ['Edit', 'tests/edit'];

        if(Auth::access('lecturer') && Auth::i_own_content($row)) {
            $this->view('tests.edit', [
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

        $tests = new Tests_model();

        $row = $tests->where('id', $id);

        if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row)) {
            $tests->delete($id);
            $this->redirect('tests');
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        $crumbs[] = ['Delete', 'tests/delete'];

        if(Auth::access('lecturer') && Auth::i_own_content($row)) {
            $this->view('tests.delete', [
                'row' => $row,
                'crumbs' => $crumbs
            ]);
        }else{
            $this->view('access-denied');
        }
    }
}
