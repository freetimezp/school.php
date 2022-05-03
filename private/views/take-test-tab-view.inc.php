<div>
    <nav class="navbar">
        <h4 class="text-center">Test questions</h4>
    </nav>

    <div>
        <?php $percentage = get_answer_percentage($row->test_id, Auth::getUser_id()); ?>
        <div class="text-center text-success"><b><?=$percentage;?>% questions has answer</b></div>
        <div style="height: 5px; width: 100%; background: #abc7e9;">
            <div class="bg-primary" style="height: 5px; width: <?=$percentage;?>%"></div>
        </div>

        <?php if($answered_test_row): ?>
            <?php if($answered_test_row->submitted): ?>
                <div class="text-center text-success">this test has been submitted</div>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center m-1">
                    <div class="text-center text-danger me-2">this test has not yet submitted</div>
                    <a onclick="submit_test(event)" href="<?=ROOT;?>/take_test/<?=$row->test_id;?>?submit=true">
                        <button class="btn btn-primary p-1">Submit</button>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <hr>

    <?php if(isset($questions) && is_array($questions)): ?>
        <form method="post">
            <?php $num = $pager->offset; ?>
            <?php foreach($questions as $question): ?>
                <?php $num++; ?>
                <div class="card mb-3 shadow">
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

                        <?php if($question->question_type != 'multiple'): ?>
                            <input class="form-control" value="<?=$myanswer;?>" type="text" name="<?=$question->id;?>" placeholder="Type your answer here">
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
                                            <input type="radio" style="transform: scale(1.5); cursor: pointer;"
                                                   name="<?=$question->id;?>" class="float-end" 
                                                <?=$myanswer==$letter?' checked ':'';?> value="<?=$letter;?>">
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <hr>

            <div class="text-center">
                <p class="text-danger"><b><i class="fa fa-smile text-success"></i>Click save before going to another page!</b></p>
                <button class="btn btn-primary">Save answers</button>
            </div>
        </form>
    <?php endif; ?>

    <div>
        <?php $pager->display(); ?>
    </div>
</div>

<script>
    let percent = <?=$percentage;?>;

    function submit_test(e) {
        if(!confirm("Are you sure you want to submit test?")) {
            e.preventDefault();
            return;
        }

        if(percent < 100) {
            if(!confirm("You have answered only " + percent + " % of test question! Submit now?")) {
                e.preventDefault();
                return;
            }
        }

    }
</script>

