<?php

class Marked_single extends Controller
{
    // in index func in params we got a $_GET values
    public function index($id = '', $user_id = '')
    {
        $errors = array();

        if(!Auth::access('student')) {
            $this->redirect('access_denied');
        }

        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $answers = new Answers_model();
        $query = "SELECT question_id, answer, answer_mark FROM answers WHERE user_id = :user_id AND test_id = :test_id";
        $saved_answers = $answers->query($query, [
            'user_id' => $user_id,
            'test_id' => $id
        ]);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Marked_single', 'marked_single'];
        if($row) {
            $crumbs[] = [$row->test, ''];
        }

        $db = new Database();

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $page_tab = 'view';

        $results = false;

        $quest = new Questions_model();
        $questions = $quest->where('test_id', $id, 'ASC', $limit, $offset);

        $all_questions = $quest->query("SELECT * FROM tests_questions WHERE test_id = :test_id", ['test_id' => $id]);
        $total_questions = is_array($all_questions) ? count($all_questions) : 0;

        //get answered test
        $data['answered_test_row'] = $tests->get_answered_test($id, $user_id);

        //set submitted
        $data['submitted'] = false;
        if(isset($data['answered_test_row']->submitted) && $data['answered_test_row']->submitted == 1) {
            $data['submitted'] = true;
        }

        //set marked
        $data['marked'] = false;
        if(isset($data['answered_test_row']->marked) && $data['answered_test_row']->marked == 1) {
            $data['marked'] = true;
        }

        //get student information
        if($data['answered_test_row']) {
            $user = new User();
            $student_row = $user->first('user_id', $data['answered_test_row']->user_id);
        }

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;
        $data['pager'] = $pager;
        $data['questions'] = $questions;
        $data['total_questions'] = $total_questions;
        $data['all_questions'] = $all_questions;
        $data['saved_answers'] = $saved_answers;
        $data['student_row'] = $student_row;
        $data['user_id'] = $user_id;

        $this->view('marked-single', $data);
    }
}
