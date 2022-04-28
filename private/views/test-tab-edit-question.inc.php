<?php if(is_object($question)): ?>

    <?php if(isset($_GET['type']) && $_GET['type'] == 'objective'): ?>
        <h4 class="text-center">Edit objective question</h4>
    <?php elseif(isset($_GET['type']) && $_GET['type'] == 'subjective'): ?>
        <h4 class="text-center">Edit subjective question</h4>
    <?php else: ?>
        <h4 class="text-center">Edit multiple question</h4>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Errors:</strong><br>
                <?php foreach ($errors as $error): ?>
                    <?=$error . "<br>"; ?>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <label class="mb-1">Question:</label>
        <textarea class="form-control mb-3" name="question" placeholder="Type your question here"><?=get_var('question', $question->question)?></textarea>

        <label class="mb-1">Comment (option):</label>
        <input type="text" value="<?=get_var('comment', $question->comment)?>" class="form-control mb-3" name="comment" placeholder="Type your comment here">

        <label class="mb-1">Upload your image for question if you need (option):</label>
        <div class="input-group mb-3">
            <label for="imageUploadQuestion" class="input-group-text btn-success"><i class="fa fa-image"></i>Image</label>
            <input type="file" name="image" class="form-control" id="imageUploadQuestion">
        </div>

        <?php if(file_exists($question->image)): ?>
            <div class="mb-3">
                <img src="<?=ROOT . '/' . $question->image;?>" alt="question" class="w-25">
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['type']) && $_GET['type'] == 'objective'): ?>
            <label class="mb-1">Your answer:</label>
            <div class="input-group mb-3">
                <input type="text" value="<?=get_var('correct_answer', $question->correct_answer)?>" name="correct_answer" class="form-control" placeholder="Enter correct answer here">
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['type']) && $_GET['type'] == 'multiple'): ?>
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <span class="me-3">Multiple choices for answer:</span><button type="button" onclick="add_choice()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i>Add new choice</button>
                </div>
                <ul class="list-group list-group-flush choice-list">

                    <?php if(isset($_POST['choice0'])): ?>
                        <?php
                        //check for multiple answers
                        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                        $num = 0;
                        foreach($_POST as $key => $value) {
                            if(strstr($key, 'choice')) {
                                ?>
                                <li class="list-group-item">
                                    <span><?=$letters[$num];?> :</span><input type="text" class="form-control mb-1" value="<?=$value;?>" name="<?=$key;?>" placeholder="Type your answer">
                                    <label>
                                        <input <?=($letters[$num] == $_POST['correct_answer']) ?'checked':''; ?> type="radio" value="<?=$letters[$num];?>" name="correct_answer">
                                        <span> Correct answer</span>
                                    </label>
                                </li>
                                <?php
                                $num++;
                            }
                        }
                        ?>
                    <?php else: ?>
                        <?php
                            $choices = json_decode($question->choices);
                            $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                            $num = 0;
                        ?>
                        <?php foreach ($choices as $letter => $answer) :?>
                            <li class="list-group-item">
                                <span><?=$letter;?> :</span><input type="text" value="<?=$answer?>" class="form-control mb-1" name="choice<?=$num;?>" placeholder="Type your answer">
                                <label>
                                    <input <?=($letter == $question->correct_answer) ?'checked':''; ?> type="radio" value="<?=$letter;?>" name="correct_answer">
                                    <span> Correct answer</span>
                                </label>
                            </li>
                        <?php $num++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <button class="btn btn-primary">Save</button>
            <a href="<?=ROOT;?>/single_test/<?=$row->test_id;?>">
                <button type="button" class="btn btn-secondary">Cancel</button>
            </a>
        </div>
    </form>
<?php else: ?>
    <div class="text-danger"><b>Sorry that question was not found!</b></div>
    <div class="text-center">
        <a href="<?=ROOT;?>/single_test/<?=$row->test_id;?>">
            <button type="button" class="btn btn-secondary">Back</button>
        </a>
    </div>
<?php endif; ?>
