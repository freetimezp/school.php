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
        <?php $num = 0; ?>
        <?php foreach($questions as $question): ?>
            <?php $num++; ?>
            <div class="card mb-3 shadow">
                <div class="card-header text-center">
                    <span class="bg-secondary col-3 p-2 rounded-1 text-white">Question #<?=$num;?></span>
                    <span class="bg-success p-2 rounded-1 text-white"><?=date('F jS, Y H:i:s a');?></span>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?=esc($question->question);?></h5>
                    <p class="card-text">1 point</p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
