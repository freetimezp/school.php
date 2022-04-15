<div class="card-group">
    <table class="table table-striped table-hover">
        <tr>
            <th></th><th>Class name</th><th>Created by</th><th>Date</th>
            <th>
                <a href="<?=ROOT;?>/classes/add">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add new</button>
                </a>
            </th>
        </tr>

        <?php if(isset($rows) && $rows): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td>
                        <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>">
                            <button class="btn btn-sm btn-primary">Details <i class="fa fa-chevron-right"></i></button>
                        </a>
                    </td>
                    <td><?=$row->class;?></td><td><?=$row->user->firstname . ' ' . $row->user->lastname;?></td><td><?=get_date($row->date);?></td>
                    <td>
                        <a href="<?=ROOT;?>/classes/edit/<?=$row->id;?>">
                            <button class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></button>
                        </a>
                        <a href="<?=ROOT;?>/classes/delete/<?=$row->id;?>">
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>No classes</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
