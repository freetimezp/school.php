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
        $query = "SELECT question_id, answer, answer_mark FROM answers WHERE user_id = :user_id AND test_id = :test_id";
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
            foreach ($_POST as $key => $value) {
                if(is_numeric($key)) {
                    //save
                    $arr['user_id'] = $user_id;
                    $arr['question_id'] = $key;
                    $arr['test_id'] = $id;
                    $arr['answer_mark'] = trim($value);

                    //check if answer already exists
                    $query = "SELECT id FROM answers WHERE user_id = :user_id AND test_id = :test_id AND question_id = :question_id LIMIT 1";
                    $check = $answers->query($query, [
                        'user_id' => $arr['user_id'],
                        'question_id' => $arr['question_id'],
                        'test_id' => $arr['test_id']
                    ]);

                    if($check) {
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
            $this->redirect('mark_test/' . $id . '/' . $user_id . $page_number);
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

        //if set as auto_mark test
        if(isset($_GET['auto_mark'])) {
            $query = "SELECT id, correct_answer FROM tests_questions WHERE test_id = :test_id AND (question_type = 'multiple' OR question_type = 'objective')";
            $original_questions = $tests->query($query, ['test_id' => $id]);

            if($original_questions) {
                foreach ($original_questions as $question_row) {
                    $query = "SELECT id, answer FROM answers WHERE user_id = :user_id AND test_id = :test_id AND question_id = :question_id LIMIT 1";
                    $answer_row = $tests->query($query, [
                        'user_id' => $user_id,
                        'test_id' => $id,
                        'question_id' => $question_row->id
                    ]);

                    if($answer_row) {
                        $answer_row = $answer_row[0];
                        $correct = strtolower(trim($question_row->correct_answer));
                        $student_answer = strtolower(trim($answer_row->answer));

                        if($correct == $student_answer) {
                            //this answer is correct
                            $answers->update($answer_row->id, [
                                'answer_mark' => 1
                            ]);
                        }else{
                            //this answer is wrong
                            $answers->update($answer_row->id, [
                                'answer_mark' => 2
                            ]);
                        }
                    }
                }
            }

            //redirect to same page
            $this->redirect('mark_test/' . $id . '/' . $user_id . $page_number);
        }

        //if its set as marked test
        if(isset($_GET['set_marked']) && (get_mark_percentage($id, $user_id) >= 100)) {
            $query = "UPDATE answered_tests SET marked = 1, marked_by = :marked_by, marked_date = :marked_date, score = :score  WHERE test_id = :test_id AND user_id = :user_id";
            $tests->query($query, [
                'test_id' => $id,
                'user_id' => $user_id,
                'marked_by' => Auth::getUser_id(),
                'marked_date' => date("Y-m-d H:i:s"),
                'score' => get_score_percentage($id, $user_id)
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
