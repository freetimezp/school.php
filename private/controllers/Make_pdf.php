<?php

class Make_pdf extends Controller
{
    function index($id = '', $user_id = '')
    {
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $folder = 'pdf/';
        if(!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        require_once __DIR__ . '/../models/mpdf/autoload.php';

        $mpdf = new \Mpdf\Mpdf();

        //$mpdf->WriteHTML('<h1>Hello world!</h1>');
        //$mpdf->Output($folder . 'mypdf.pdf');
        //$this->view('home');

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

        extract($data);
        ?>

        <?php if($row && $answered_test_row && $answered_test_row->submitted): ?>
            <table>
                <tr>
                    <th>Class:</th><td><?=$row->class->class;?></td>
                </tr>
                <tr>
                    <th>Student:</th><td><?=$student_row->firstname . ' ' . $student_row->lastname;?></td>
                </tr>
                <tr>
                    <th>Test Name:</th><td><?=esc($row->test);?></td>
                </tr>
                <tr>
                    <th>Description:</th><td><?=esc($row->description);?></td>
                </tr>
                <tr>
                    <th>Total questions:</th><td><?=$total_questions;?></td>
                </tr>
                <tr>
                    <th>Created by:</th>
                    <td><?=esc($row->user->firstname);?> <?=esc($row->user->lastname);?></td>
                </tr>
                <tr>
                    <th>Date Created:</th><td><?=get_date($row->date);?></td>
                </tr>
                <tr>
                    <th>Active:</th><td><?=$row->disabled?'No':'Yes';?></td>
                </tr>
            </table>
        <?php endif; ?>


        <?php
    }
}


