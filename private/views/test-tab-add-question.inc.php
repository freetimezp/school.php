<?php if(isset($_GET['type']) && $_GET['type'] == 'objective'): ?>
    <h4 class="text-center">Add objective question</h4>
<?php elseif(isset($_GET['type']) && $_GET['type'] == 'subjective'): ?>
    <h4 class="text-center">Add subjective question</h4>
<?php else: ?>
    <h4 class="text-center">Add multiple question</h4>
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
    <textarea class="form-control mb-3" name="question" placeholder="Type your question here"><?=get_var('question')?></textarea>

    <label class="mb-1">Comment (option):</label>
    <input type="text" value="<?=get_var('comment')?>" class="form-control mb-3" name="comment" placeholder="Type your comment here">

    <label class="mb-1">Upload your image for question if you need  (option):</label>
    <div class="input-group mb-3">
        <label class="input-group-text btn-success"><i class="fa fa-image"></i>Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <?php if(isset($_GET['type']) && $_GET['type'] == 'objective'): ?>
        <label class="mb-1">Your answer:</label>
        <div class="input-group mb-3">
            <input type="text" value="<?=get_var('correct_answer')?>" name="correct_answer" class="form-control" placeholder="Enter correct answer here">
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
                    <li class="list-group-item">
                        <span>A :</span><input type="text" class="form-control mb-1" name="choice0" placeholder="Type your answer">
                        <label><input type="radio" value="A" name="correct_answer"><span> Correct answer</span></label>
                    </li>
                    <li class="list-group-item">
                        <span>B :</span><input type="text" class="form-control mb-1" name="choice1" placeholder="Type your answer">
                        <label><input type="radio" value="B" name="correct_answer"><span> Correct answer</span></label>
                    </li>
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

<script>
    let letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];


    function add_choice() {
        let choices = document.querySelector('.choice-list');

        if(choices.children.length < letters.length) {
            choices.innerHTML += `
            <li class="list-group-item">
                <span>${letters[choices.children.length]} :</span><input type="text" class="form-control mb-1" name="choice${choices.children.length}" placeholder="Type your answer">
                <label>
                    <input value="${letters[choices.children.length]}" type="radio" name="correct_answer"><span> Correct answer</span>
                </label>
            </li>
        `;
        }
    }
</script>