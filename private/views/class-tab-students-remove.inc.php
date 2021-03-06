<form method="post">
    <h4>Remove student</h4>

    <?php if(count($errors) > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Errors:</strong><br>
            <?php foreach ($errors as $error): ?>
                <?=$error . "<br>"; ?>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <input class="form-control" type="text" value="<?=get_var('name');?>" name="name" placeholder="Student name">
    <hr>
    <button class="btn btn-primary" name="search">Search</button>
    <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=students">
        <button type="button" class="btn btn-danger">Cancel</button>
    </a>
    <hr>
</form>

<form method="post">
    <div class="card-group justify-content-center">
        <?php if(isset($results) && $results): ?>
            <?php foreach ($results as $row): ?>

                <?php include(views_path('user'));?>

            <?php endforeach; ?>
        <?php else: ?>
            <?php if(count($_POST) > 0): ?>
                <hr>
                <h4>No students were found</h4>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</form>
