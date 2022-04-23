<?php if(isset($test_row) && is_object($test_row)): ?>
    <form method="post">
        <h4>Delete test</h4>

        <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Errors:</strong><br>
                <?php foreach ($errors as $error): ?>
                    <?=$error . "<br>"; ?>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <label>Test name:</label>
        <input readonly class="form-control mb-2" type="text" value="<?=get_var('test', $test_row->test);?>" name="test" placeholder="Test name">

        <label>Test description:</label>
        <textarea readonly name="description" class="form-control mb-4" placeholder="Add a description for this test"><?=get_var('description', $test_row->description);?></textarea>

        <input class="btn btn-danger" type="submit" value="Delete">
        <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests"">
            <button type="button" class="btn btn-secondary">Cancel</button>
        </a>

    </form>
<?php else: ?>
    <div>Sorry, that test was not found!</div>
    <br>
    <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests"">
        <button type="button" class="btn btn-secondary">Back</button>
    </a>
<?php endif; ?>




