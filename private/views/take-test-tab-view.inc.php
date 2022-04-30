<div>
    <nav class="navbar">
        <h4 class="text-center">Test questions</h4>
    </nav>

    <hr>

    <?php if(isset($questions) && is_array($questions)): ?>
        <form method="post">
            <?php $num = 0; ?>
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
                            <input class="form-control" type="text" name="<?=$question->id;?>" placeholder="Type your answer here">
                        <?php elseif($question->question_type == 'subjective'): ?>
                            <?php $type = '?type=subjective'; ?>
                            <input class="form-control" type="text" name="<?=$question->id;?>" placeholder="Type your answer here">
                        <?php endif; ?>

                        <?php if($question->question_type == 'multiple'): ?>
                            <?php $type = '?type=multiple'; ?>

                            <div class="card">
                                <div class="card-header">
                                    Select your answer
                                </div>
                                <ul class="list-group list-group-flush">
                                    <?php $choices = json_decode($question->choices); ?>

                                    <?php foreach ($choices as $letter => $answer): ?>
                                        <li class="list-group-item w-25 d-flex align-items-center justify-content-between">
                                            <span style="vertical-align: center;"><?=$letter;?>: <?=$answer;?></span>
                                            <input type="radio" style="transform: scale(1.5); cursor: pointer;" name="<?=$question->id;?>" class="float-end" value="<?=$letter;?>">
                                            <span class="clearfix"></span>
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
                <button class="btn btn-primary">Save answers</button>
            </div>
        </form>
    <?php endif; ?>
</div>

