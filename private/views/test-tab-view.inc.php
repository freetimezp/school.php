<div>
    <nav class="navbar">
        <h4 class="text-center">Test questions</h4>

        <?php if($row->disabled): ?>
            <div class="btn-group">
                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bars"></i>Add
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="<?=ROOT;?>/single_test/addquestion/<?=$row->test_id;?>?type=multiple">
                            Add multiple choice question
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?=ROOT;?>/single_test/addquestion/<?=$row->test_id;?>?type=objective">
                            Add objective question
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?=ROOT;?>/single_test/addquestion/<?=$row->test_id;?>?type=subjective">
                            Add subjective question
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </nav>

    <hr>

    <?php if(isset($questions) && is_array($questions)): ?>
        <?php $num = ($total_questions + 1); ?>
        <?php foreach($questions as $question): ?>
            <?php $num--; ?>
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
                        <p class="card-text">Answer: <?=esc($question->correct_answer);?></p>
                    <?php endif; ?>

                    <?php if($question->question_type == 'multiple'): ?>
                        <?php $type = '?type=multiple'; ?>

                        <div class="card w-50">
                            <div class="card-header">
                                Multiple choice
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php $choices = json_decode($question->choices); ?>

                                <?php foreach ($choices as $key => $choice): ?>
                                    <li class="list-group-item">
                                        <?=$key;?>: <?=$choice;?>

                                        <?php if(trim($key) == trim($question->correct_answer)): ?>
                                            <i class="fa fa-check"></i>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <br>

                        <p class="card-text">Answer: <?=esc($question->correct_answer);?></p>
                    <?php endif; ?>
                </div>
                <div class="card-footer p-3">
                    <?php if($row->editable): ?>
                        <a href="<?=ROOT;?>/single_test/editquestion/<?=$row->test_id;?>/<?=$question->id;?><?=$type;?>">
                            <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>Edit</button>
                        </a>
                        <a href="<?=ROOT;?>/single_test/deletequestion/<?=$row->test_id;?>/<?=$question->id;?><?=$type;?>">
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i>Delete</button>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
