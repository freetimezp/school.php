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

        $limit = 3000;
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
            <style>
                table, .marked_single {
                    padding: 20px;
                    width: 100%;
                    max-width: 800px;
                    margin: auto;
                }

                table tr {
                    width: 100%;
                    transition: all 0.5s ease;
                    background: #fff;
                }

                table tr th {
                    width: 200px;
                    text-align: left;
                    padding: 5px 10px;
                    border: 1px solid #cbd3d9;
                    font-weight: 700;
                    transition: all 0.5s ease;
                    background: #fff;
                }

                table tr td {
                    text-align: left;
                    padding: 5px 20px;
                    border: 1px solid #cbd3d9;
                    transition: all 0.5s ease;
                    background: #fff;
                }

                table tr:hover th, table tr:hover td {
                    background: #cbd3d9;
                }

                .marked_single nav h4 {
                    font-size: 30px;
                    text-align: center;
                }

                .text_answer, .text_marked {
                    text-align: center;
                }

                .row_answer {
                    height: 5px;
                    width: 100%;
                    background: #abc7e9;
                    margin-bottom: 10px;
                }

                .row_marked {
                    height: 5px;
                    width: 100%;
                    background: #bababe;
                }

                .row_answer_success {
                    background: #2a5fa0;
                }

                .row_marked_success {
                    background: #373753;
                }

                .row_score {
                    padding: 10px 0;
                    text-align: center;
                    margin-bottom: 20px;
                }

                .text_score {
                    font-size: 40px;
                    color: #167247;
                }

                .row_question {
                    padding: 10px 20px;
                }

                .d-questions {
                    padding: 10px;
                    border: 1px solid #0c4128;
                    border-radius: 5px;
                    margin-bottom: 30px;
                    transition: all 0.5s ease;
                    box-shadow: 0 0 0 #0c4128;
                }

                .row_question .tab-1 {
                    background: #86b7fe;
                    padding: 5px 10px;
                    margin-right: 5px;
                    transition: all 0.5s ease;
                }

                .row_question .tab-2 {
                    background: #a6fe86;
                    padding: 5px 10px;
                    margin-right: 5px;
                    transition: all 0.5s ease;
                }

                .row_question .tab-3 {
                    background: #fe86e4;
                    padding: 5px 10px;
                    transition: all 0.5s ease;
                }

                .d-questions:hover {
                    box-shadow: 0 0 15px #0c4128;
                }

                .d-questions:hover .row_question .tab-1 {
                    background: #5b96ec;
                }

                .d-questions:hover .row_question .tab-2 {
                    background: #5ee22f;
                }

                .d-questions:hover .row_question .tab-3 {
                    background: #ef45ca;
                }

                .d-questions img {
                    width: 400px;
                    height: 250px;
                }
            </style>

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

            <div class="marked_single">
                <nav>
                    <h4>Test questions</h4>
                </nav>

                <div>
                    <?php $percentage = get_answer_percentage($row->test_id, $user_id); ?>
                    <?php $marked_percentage = get_mark_percentage($row->test_id, $user_id); ?>

                    <div>
                        <div class="text_answer"><b><?=$percentage;?>% questions has answer</b></div>
                        <div class="row_answer">
                            <div class="row_answer_success"  style="height: 5px; width: <?=$percentage;?>%;"></div>
                        </div>

                        <div class="text_marked"><b><?=$marked_percentage;?>% questions has marked</b></div>
                        <div class="row_marked">
                            <div class="row_marked_success"  style="height: 5px; width: <?=$marked_percentage;?>%;"></div>
                        </div>
                    </div>
                </div>

                <div class="row_score">
                    <?php $score_percentage = get_score_percentage($row->test_id, $user_id); ?>
                    <span>Score: </span><span class="text_score"><?=$score_percentage;?>%</span>
                </div>


                <?php if(isset($questions) && is_array($questions)): ?>
                    <form method="post">
                        <?php $num = $pager->offset; ?>
                        <?php foreach($questions as $question): ?>
                            <?php $num++; ?>
                            <?php
                            $mymark = get_answer_mark($saved_answers, $question->id);
                            $border = '';
                            if($mymark == 1) {
                                $border = ' border-success border-1 ';
                            }elseif($mymark == 2) {
                                $border = ' border-danger border-1 ';
                            }else{
                                $border = ' border-warning border-1 ';
                            }
                            ?>
                            <div class="d-questions card mb-3 shadow <?=$border;?>">
                                <div class="row_question">
                                    <span class="tab-1">Question #<?=$num;?></span>
                                    <span class="tab-2"><?=date('F jS, Y H:i:s a', strtotime($question->date));?></span>
                                    <span class="tab-3"><?=$question->question_type;?></span>
                                </div>
                                <div class="card-body mb-3">
                                    <h5 class="card-title mb-3"><?=esc($question->question);?></h5>

                                    <?php if(file_exists($question->image)):?>
                                        <img src="<?=ROOT . '/' .$question->image;?>" class="col-6 mb-3" alt="question">
                                    <?php endif; ?>

                                    <p class="card-text">Comment: <?=esc($question->comment);?></p>
                                    <hr>
                                    <?php $type = ''; ?>
                                    <?php if($question->question_type == 'objective'): ?>
                                        <?php $type = '?type=objective'; ?>
                                    <?php elseif($question->question_type == 'subjective'): ?>
                                        <?php $type = '?type=subjective'; ?>
                                    <?php endif; ?>

                                    <?php $myanswer = get_answer($saved_answers, $question->id); ?>
                                    <?php $mymark = get_answer_mark($saved_answers, $question->id); ?>

                                    <?php if($question->question_type != 'multiple'): ?>
                                        <div>
                                            <span style="font-weight: 700;">Student answer: </span>
                                            <span><?=$myanswer;?></span>
                                        </div>
                                        <div style="display: flex; align-items: center;">
                                            <span style="font-weight: 700;">Teachers mark: </span>
                                            <div style="font-size: 50px; margin-left: 20px;">
                                                <?=($mymark==1)?
                                                    '<span style="color: green; font-weight: 700;">TRUE</span>':
                                                    '<span style="color: red; font-weight: 700;">FALSE</span>';?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($question->question_type == 'multiple'): ?>
                                        <?php $type = '?type=multiple'; ?>

                                        <div>
                                            <div style="font-weight: bold;">Student answer:</div>
                                            <ul>
                                                <?php $choices = json_decode($question->choices); ?>

                                                <?php foreach ($choices as $letter => $answer): ?>
                                                    <li class="list-group-item d-flex align-items-center justify-content-between" style="width:400px;">
                                                        <span style="vertical-align: center;"><?=$letter;?>: <?=$answer;?></span>

                                                        <?php if($myanswer == $letter): ?>
                                                            <span style="margin-left: 40px">V (selected)</span>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>

                                            <div style="display: flex; align-items: center;">
                                                <span style="font-weight: 700;">Teachers mark: </span>
                                                <div style="font-size: 50px; margin-left: 20px;">
                                                    <?=($mymark==1)?
                                                        '<span style="color: green; font-weight: 700;">TRUE</span>':
                                                        '<span style="color: red; font-weight: 700;">FALSE</span>';?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                    </form>
                <?php endif; ?>
            </div>

    <?php endif; ?>

        <?php
    }
}


