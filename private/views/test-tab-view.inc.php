<div>
    <nav class="navbar">
        <h4 class="text-center">Test questions</h4>

        <div class="btn-group">
            <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bars"></i>Add
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="<?=ROOT;?>/single_test/addmultiple/<?=$row->test_id;?>">
                        Add multiple choice question
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="<?=ROOT;?>/single_test/addobjective/<?=$row->test_id;?>">
                        Add objective question
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="<?=ROOT;?>/single_test/addsubjective/<?=$row->test_id;?>">
                        Add subjective question
                    </a>
                </li>
            </ul>
        </div>
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
                </div>
                <div class="card-body mb-3">
                    <h5 class="card-title mb-3"><?=esc($question->question);?></h5>

                    <?php if(file_exists($question->image)):?>
                        <img src="<?=ROOT . '/' .$question->image;?>" class="col-6 mb-3" alt="question">
                    <?php endif; ?>

                    <p class="card-text"><?=esc($question->comment);?></p>
                </div>
                <div class="card-footer p-3">
                    <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>Edit</button>
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i>Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
