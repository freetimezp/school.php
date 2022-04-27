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

        <label class="mb-1">Comment:</label>
        <input type="text" value="<?=get_var('comment', $question->comment)?>" class="form-control mb-3" name="comment" placeholder="Type your comment here">

        <label class="mb-1">Upload your image for question if you need:</label>
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
