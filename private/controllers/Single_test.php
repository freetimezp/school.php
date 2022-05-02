<?php

class Single_test extends Controller
{
    public function index($id = '')
    {
        $errors = array();

        if(!Auth::access('lecturer')) {
            $this->redirect('access_denied');
        }

        $tests = new Tests_model();

        $row = $tests->first('test_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if($row) {
            $crumbs[] = [$row->test, ''];
        }

        if(isset($_GET['disable'])) {
            if($row->disabled) {
                $disable = 0;
            }else {
                $disable = 1;
            }
            $query = "UPDATE tests SET disabled = $disable WHERE id = :id LIMIT 1";
            $tests->query($query, ['id' => $row->id]);
        }

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $page_tab = 'view';

        $results = false;

        $quest = new Questions_model();
        $questions = $quest->where('test_id', $id);
        $total_questions = is_array($questions) ? count($questions) : 0;

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

    public function addquestion($id = '')
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

        $page_tab = 'add-question';

        $quest = new Questions_model();

        if(count($_POST) > 0) {
            if($quest->validate($_POST)) {
                //check for uploaded files
                if($myImage = upload_image($_FILES)) {
                    $_POST['image'] = $myImage;
                }

                $_POST['date'] = date("Y-m-d H:i:s");
                $_POST['test_id'] = $id;

                if(isset($_GET['type']) && $_GET['type'] == 'multiple') {
                    $_POST['question_type'] = 'multiple';

                    $arr = [];
                    $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                    $num = 0;

                    foreach($_POST as $key => $value) {
                        if(strstr($key, 'choice')) {
                            $arr[$letters[$num]] = $value;
                            $num++;
                        }
                    }

                    $_POST['choices'] = json_encode($arr);
                }elseif(isset($_GET['type']) && $_GET['type'] == 'objective') {
                    $_POST['question_type'] = 'objective';
                }else{
                    $_POST['question_type'] = 'subjective';
                }

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

    public function editquestion($id = '', $quest_id = '')
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

        $page_tab = 'edit-question';

        $quest = new Questions_model();
        $question = $quest->first('id', $quest_id);

        if(count($_POST) > 0) {
            if(!$row->editable) {
                $errors[] = 'This test question is disabled for editing!';
            }

            if($quest->validate($_POST) && count($errors) == 0) {
                //check for uploaded files
                if($myImage = upload_image($_FILES)) {
                    $_POST['image'] = $myImage;
                    //save and delete old image
                    if($old_image = $question->image) {
                        unlink($old_image);
                    }
                }

                //check question type
                $type = '';

                if(isset($_GET['type']) && $_GET['type'] == 'multiple') {
                    $_POST['question_type'] = 'multiple';
                    $type = 'multiple';

                    $arr = [];
                    $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                    $num = 0;

                    foreach($_POST as $key => $value) {
                        if(strstr($key, 'choice')) {
                            $arr[$letters[$num]] = $value;
                            $num++;
                        }
                    }

                    $_POST['choices'] = json_encode($arr);

                    $type = '?type=multiple';
                }elseif($question->question_type == 'objective') {
                    $type = '?type=objective';
                }else{
                    $type = '?type=subjective';
                }

                $quest->update($question->id, $_POST);

                $this->redirect('single_test/editquestion/' . $id . '/' . $quest_id . $type);
            }else{
                $errors = array_merge($errors, $quest->errors);
            }
        }

        $results = false;

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;
        $data['pager'] = $pager;
        $data['question'] = $question;

        $this->view('single-test', $data);
    }

    public function deletequestion($id = '', $quest_id = '')
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

        $page_tab = 'delete-question';

        $quest = new Questions_model();
        $question = $quest->first('id', $quest_id);

        if(!$row->editable) {
            $errors[] = 'This test question can not be deleted!';
        }

        if(count($_POST) > 0 && count($errors) == 0) {
            if(Auth::access('lecturer')) {
                $old_image = $question->image;

                $quest->delete($question->id);

                //save and delete old image
                if($old_image) {
                    unlink($old_image);
                }

                $this->redirect('single_test/' . $id );
            }
        }

        $results = false;

        $data['row'] = $row;
        $data['page_tab'] = $page_tab;
        $data['crumbs'] = $crumbs;
        $data['results'] = $results;
        $data['errors'] = $errors;
        $data['pager'] = $pager;
        $data['question'] = $question;

        $this->view('single-test', $data);
    }

}
