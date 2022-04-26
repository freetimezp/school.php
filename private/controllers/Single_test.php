<?php

class Single_test extends Controller
{
    public function index($id = '')
    {
        $errors = array();

        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();

        $row = $tests->first('test_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if($row) {
            $crumbs[] = [$row->test, ''];
        }

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $page_tab = 'view';

        $results = false;

        $quest = new Questions_model();
        $questions = $quest->where('test_id', $id);
        $total_questions = count($questions);

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;
        $data['pager'] = $pager;
        $data['questions'] = $questions;
        $data['total_questions'] = $total_questions;

        $this->view('single-test', $data);
    }

    public function addsubjective($id = '')
    {
        $errors = array();

        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();

        $row = $tests->first('test_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if($row) {
            $crumbs[] = [$row->test, ''];
        }

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $page_tab = 'add-subjective';

        $quest = new Questions_model();

        if(count($_POST) > 0) {
            if($quest->validate($_POST)) {
                $_POST['date'] = date("Y-m-d H:i:s");
                $_POST['question_type'] = 'subjective';
                $_POST['test_id'] = $id;

                $quest->insert($_POST);
                $this->redirect('single_test/' . $id);
            }else{
                $errors = $quest->errors;
            }
        }

        $results = false;

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;
        $data['pager'] = $pager;

        $this->view('single-test', $data);
    }
}
