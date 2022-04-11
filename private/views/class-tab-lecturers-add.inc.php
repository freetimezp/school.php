<form method="post">
    <h4>Add lecturer</h4>
    <input class="form-control" type="text" value="<?=get_var('name');?>" name="name" placeholder="Lecturer name">
    <hr>
    <button class="btn btn-primary" name="search">Search</button>
    <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=lecturers"">
        <button type="button" class="btn btn-danger">Cancel</button>
    </a>
    <hr>
</form>

<div class="container-fluid">
    <?php if(isset($results) && $results): ?>
        <table class="table table-striped table-hover">
            <tr><th>Name</th><th>Rank</th><th>Action</th></tr>

            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?=$row->firstname;?> <?=$row->lastname;?></td>
                    <td><?=$row->rank;?></td>
                    <td>
                        <button class="btn btn-sm btn-primary">Add</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <?php if(count($_POST) > 0): ?>
            <hr>
            <h4>No lecturers were found</h4>
        <?php endif; ?>
    <?php endif; ?>
</div>