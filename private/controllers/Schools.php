<?php

class Schools extends Controller
{
    public function index() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $school = new School();
        $data = $school->findAll();
        $this->view('schools', ['rows' => $data]);
    }

    public function add() {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        if(count($_POST) > 0) {
            $school = new School();

            if($school->validate($_POST)) {
                $_POST['date'] = date("Y-m-d H:i:s");

                $school->insert($_POST);
                $this->redirect('schools');
            }else{
                $errors = $school->errors;
            }
        }

        $this->view('schools.add', [
            'errors' => $errors
        ]);
    }

    public function edit($id = null) {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        $school = new School();

        if(count($_POST) > 0) {
            if($school->validate($_POST)) {
                $school->update($id, $_POST);
                $this->redirect('schools');
            }else{
                $errors = $school->errors;
            }
        }

        $row = $school->where('id', $id);

        $this->view('schools.edit', [
            'row' => $row,
            'errors' => $errors
        ]);
    }


}