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

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;
        $data['pager'] = $pager;

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
