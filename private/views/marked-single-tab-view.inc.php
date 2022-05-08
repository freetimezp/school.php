<div>
    <nav class="navbar">
        <h4 class="text-center">Test questions</h4>
    </nav>

    <div>
        <?php $percentage = get_answer_percentage($row->test_id, $user_id); ?>
        <?php $marked_percentage = get_mark_percentage($row->test_id, $user_id); ?>

        <div class="p-2 m-3">
            <div class="text-center text-success"><b><?=$percentage;?>% questions has answer</b></div>
            <div class="mb-2" style="height: 5px; width: 100%; background: #abc7e9;">
                <div class="bg-primary" style="height: 5px; width: <?=$percentage;?>%"></div>
            </div>

            <div class="text-center text-dark"><b><?=$marked_percentage;?>% questions has marked</b></div>
            <div style="height: 5px; width: 100%; background: #bababe;">
                <div class="bg-dark" style="height: 5px; width: <?=$marked_percentage;?>%"></div>
            </div>
        </div>
    </div>

    <?php if($marked): ?>
        <div class="text-center">
            <?php $score_percentage = get_score_percentage($row->test_id, $user_id); ?>
            <span>Score: </span><span style="font-size: 40px;"><?=$score_percentage;?>%</span>
        </div>
    <?php endif; ?>
    <hr>

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
                <div class="card mb-3 shadow <?=$border;?>">
                    <div class="card-header text-center p-3">
                        <span class="bg-secondary col-3 p-2 rounded-1 text-white">Question #<?=$num;?></span>
                        <span class="bg-success p-2 rounded-1 text-white"><?=date('F jS, Y H:i:s a', strtotime($question->date));?></span>
                        <span class="bg-primary col-3 p-2 rounded-1 text-white"><?=$question->question_type;?></span>
                    </div>
                    <div class="card-body mb-3">
                        <h5 class="card-title mb-3"><?=esc($question->question);?></h5>

                        <?php if(file_exists($question->image)):?>
                            <img src="<?=ROOT . '/' .$question->image;?>" class="col-6 mb-3" alt="question">
                        <?php endif; ?>

                        <p class="card-text"><?=esc($question->comment);?></p>

                        <?php $type = ''; ?>
                        <?php if($question->question_type == 'objective'): ?>
                            <?php $type = '?type=objective'; ?>
                        <?php elseif($question->question_type == 'subjective'): ?>
                            <?php $type = '?type=subjective'; ?>
                        <?php endif; ?>

                        <?php $myanswer = get_answer($saved_answers, $question->id); ?>
                        <?php $mymark = get_answer_mark($saved_answers, $question->id); ?>

                        <?php if($question->question_type != 'multiple'): ?>
                            <div>Answer: <?=$myanswer;?></div>
                            <hr>
                            <h6>Teachers mark:</h6>
                            <div style="font-size: 50px;" class="text-center">
                                <?=($mymark==1)?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';?>
                            </div>
                        <?php endif; ?>

                        <?php if($question->question_type == 'multiple'): ?>
                            <?php $type = '?type=multiple'; ?>

                            <div class="card">
                                <div class="card-header">Select your answer</div>
                                <ul class="list-group list-group-flush">
                                    <?php $choices = json_decode($question->choices); ?>

                                    <?php foreach ($choices as $letter => $answer): ?>
                                        <li class="list-group-item d-flex align-items-center justify-content-between" style="width:400px;">
                                            <span style="vertical-align: center;"><?=$letter;?>: <?=$answer;?></span>

                                            <?php if($myanswer == $letter): ?>
                                                <i class="fa fa-check"></i>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                                <hr>

                                <div class="ps-3">
                                    <h6>Teachers mark:</h6>
                                    <div style="font-size: 50px;" class="text-center">
                                        <?=($mymark==1)?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';?>
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

    <div>
        <?php $pager->display(); ?>
    </div>
</div>




