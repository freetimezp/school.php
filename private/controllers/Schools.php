<?php

class Schools extends Controller
{
    public function index() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $school = new School();

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];

        $data = $school->findAll();

        if(Auth::access('super_admin')) {
            $this->view('schools', [
               'rows' => $data,
               'crumbs' => $crumbs
            ]);
        }else{
            $this->view('access-denied');
        }
    }

    public function add() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        if(count($_POST) > 0 && Auth::access('super_admin')) {
            $school = new School();

            if($school->validate($_POST)) {
                $_POST['date'] = date("Y-m-d H:i:s");

                $school->insert($_POST);
                $this->redirect('schools');
            }else{
                $errors = $school->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Add', 'schools/add'];

        if(Auth::access('super_admin')) {
            $this->view('schools.add', [
                'errors' => $errors,
                'crumbs' => $crumbs
            ]);
        }else{
            $this->view('access-denied');
        }
    }

    public function edit($id = null) {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        $school = new School();

        if(count($_POST) > 0 && Auth::access('super_admin')) {
            if($school->validate($_POST)) {
                $school->update($id, $_POST);
                $this->redirect('schools');
            }else{
                $errors = $school->errors;
            }
        }

        $row = $school->where('id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Edit', 'schools/edit'];

        if(Auth::access('super_admin')) {
                $this->view('schools.edit', [
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

        $school = new School();

        if(count($_POST) > 0 && Auth::access('super_admin')) {
            $school->delete($id);
            $this->redirect('schools');
        }

        $row = $school->where('id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Delete', 'schools/delete'];

        if(Auth::access('super_admin')) {
            $this->view('schools.delete', [
                'row' => $row,
                'crumbs' => $crumbs
            ]);
        }else{
            $this->view('access-denied');
        }
    }
}