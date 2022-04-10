<form method="post">
    <h4>Add lecturer</h4>
    <input class="form-control" type="text" name="name" placeholder="Lecturer name">
    <hr>
    <button class="btn btn-primary">Search</button>
    <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=lecturers"">
        <button type="button" class="btn btn-danger">Cancel</button>
    </a>
</form>

<div class="container-fluid">
    <?php if(isset($results) && $results): ?>
        <?php foreach ($results as $row): ?>

            <?php include(views_path('user')); ?>

        <?php endforeach; ?>
    <?php else: ?>
        <?php if(count($_POST) > 0): ?>
            <hr>
            <h4>No lecturers were found</h4>
        <?php endif; ?>
    <?php endif; ?>
</div>