<?php

class Mark_test extends Controller
{
    // in index func in params we got a $_GET values
    public function index($id = '', $user_id = '')
    {
        $errors = array();

        if(!Auth::access('lecturer')) {
            $this->redirect('access_denied');
        }

        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $answers = new Answers_model();
        $query = "SELECT question_id, answer FROM answers WHERE user_id = :user_id AND test_id = :test_id";
        $saved_answers = $answers->query($query, [
            'user_id' => $user_id,
            'test_id' => $id
        ]);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if($row) {
            $crumbs[] = [$row->test, ''];

            if(!$row->disabled) {
                $query = "UPDATE tests SET editable = 0 WHERE id = :id LIMIT 1";
                $tests->query($query, ['id' => $row->id]);
            }
        }

        $db = new Database();

        //if something was posted
        if(count($_POST) > 0) {
            //save answers to db
            $arr = []; // table answers
            $arr1 = []; // table answered_tests

            $arr1['user_id'] = $user_id;
            $arr1['test_id'] = $id;

            $check = $db->query("SELECT id FROM answered_tests WHERE user_id = :user_id AND test_id = :test_id LIMIT 1", $arr1);
            if(!$check) {
                $arr1['date'] = date("Y-m-d H:i:s");
                $query = "INSERT INTO answered_tests (user_id, test_id, date) VALUES (:user_id, :test_id, :date)";
                $db->query($query, $arr1);
            }

            foreach ($_POST as $key => $value) {
                if(is_numeric($key)) {
                    //save
                    $arr['user_id'] = $user_id;
                    $arr['question_id'] = $key;
                    $arr['date'] = date("Y-m-d H:i:s");
                    $arr['test_id'] = $id;
                    $arr['answer'] = trim($value);

                    //check if answer already exists
                    $query = "SELECT id FROM answers WHERE user_id = :user_id AND test_id = :test_id AND question_id = :question_id LIMIT 1";
                    $check = $answers->query($query, [
                        'user_id' => $arr['user_id'],
                        'question_id' => $arr['question_id'],
                        'test_id' => $arr['test_id']
                    ]);

                    if(!$check) {
                        $answers->insert($arr);
                    }else{
                        $answer_id = $check[0]->id;

                        unset($arr['user_id']);
                        unset($arr['question_id']);
                        unset($arr['date']);
                        unset($arr['test_id']);

                        $answers->update($answer_id, $arr);
                    }
                }
            }

            $page_number = "&page=1";
            if(!empty($_GET['page'])) {
                $page_number = "&page=" . $_GET['page'];
            }
            $this->redirect('take_test/' . $id . $page_number);
        }

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $page_tab = 'view';

        $results = false;

        $quest = new Questions_model();
        $questions = $quest->where('test_id', $id, 'ASC', $limit, $offset);

        $all_questions = $quest->query("SELECT * FROM tests_questions WHERE test_id = :test_id", ['test_id' => $id]);
        $total_questions = is_array($all_questions) ? count($all_questions) : 0;

        //unsubmit test
        if(isset($_GET['unsubmit'])) {
            $query = "UPDATE answered_tests SET submitted = 0, submitted_date = :sub_date WHERE test_id = :test_id AND user_id = :user_id";
            $tests->query($query, [
                'test_id' => $id,
                'user_id' => $user_id,
                'sub_date' => NULL
            ]);
        }

        //marked test
        if(isset($_GET['set_marked'])) {
            $query = "UPDATE answered_tests SET marked = 1, marked_by = :marked_by , marked_date = :marked_date WHERE test_id = :test_id AND user_id = :user_id";
            $tests->query($query, [
                'test_id' => $id,
                'user_id' => $user_id,
                'marked_by' => Auth::getUser_id(),
                'marked_date' => date("Y-m-d H:i:s")
            ]);
        }

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

        $this->view('mark-test', $data);
    }
}
