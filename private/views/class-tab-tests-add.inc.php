<form method="post">
    <h4>Add test</h4>

    <?php if(count($errors) > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Errors:</strong><br>
            <?php foreach ($errors as $error): ?>
                <?=$error . "<br>"; ?>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <input class="form-control mb-2" type="text" value="<?=get_var('test');?>" name="test" placeholder="Test name">
    <textarea name="description" class="form-control mb-4" placeholder="Add a description for this test"><?=get_var('description');?></textarea>

    <input class="btn btn-primary" type="submit" value="Create">
    <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests"">
        <button type="button" class="btn btn-danger">Cancel</button>
    </a>

    <hr class="clearfix">
</form>


