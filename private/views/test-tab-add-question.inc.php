<?php if(isset($_GET['type']) && $_GET['type'] == 'objective'): ?>
    <h4 class="text-center">Add objective question</h4>
<?php else: ?>
    <h4 class="text-center">Add subjective question</h4>
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

    <label class="mb-1">Comment:</label>
    <input type="text" value="<?=get_var('comment')?>" class="form-control mb-3" name="comment" placeholder="Type your comment here">

    <label class="mb-1">Upload your image for question if you need:</label>
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


    <div class="text-center">
        <button class="btn btn-primary">Save</button>
        <a href="<?=ROOT;?>/single_test/<?=$row->test_id;?>">
            <button type="button" class="btn btn-secondary">Cancel</button>
        </a>
    </div>
</form>
