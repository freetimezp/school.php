<?php if(isset($test_row) && is_object($test_row)): ?>
    <form method="post">
        <h4>Edit test</h4>

        <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Errors:</strong><br>
                <?php foreach ($errors as $error): ?>
                    <?=$error . "<br>"; ?>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <input class="form-control mb-2" type="text" value="<?=get_var('test', $test_row->test);?>" name="test" placeholder="Test name">
        <textarea name="description" class="form-control mb-4" placeholder="Add a description for this test"><?=get_var('description', $test_row->description);?></textarea>

        <?php
            $disabled = get_var('disabled', $test_row->disabled);
            $active_checked = '';
            $disabled_checked = '';

            if($disabled == 1) {
                $disabled_checked = 'checked';
            }else{
                $active_checked = 'checked';
            }
        ?>
        <input type="radio" name="disabled" value="0" <?=$active_checked;?> > Enabled |
        <input type="radio" name="disabled" value="1" <?=$disabled_checked;?> > Disabled
        <hr>

        <input class="btn btn-primary" type="submit" value="Save">
        <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests"">
            <button type="button" class="btn btn-danger">Cancel</button>
        </a>

    </form>
<?php else: ?>
    <div>Sorry, that test was not found!</div>
    <br>
    <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests"">
        <button type="button" class="btn btn-secondary">Back</button>
    </a>
<?php endif; ?>



