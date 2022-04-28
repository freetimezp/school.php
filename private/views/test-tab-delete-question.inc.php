<?php if(is_object($question)): ?>

    <h4 class="text-center">Delete question</h4>
    <h5 class="text-center">Are you sure?</h5>

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
        <textarea readonly class="form-control mb-3" name="question" placeholder="Type your question here"><?=get_var('question', $question->question)?></textarea>

        <?php if(file_exists($question->image)): ?>
            <div class="mb-3">
                <img src="<?=ROOT . '/' . $question->image;?>" alt="question" class="w-25">
            </div>
        <?php endif; ?>

        <div class="text-center">
            <button class="btn btn-danger">Delete</button>
            <a href="<?=ROOT;?>/single_test/<?=$row->test_id;?>">
                <button type="button" class="btn btn-secondary">Back</button>
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
