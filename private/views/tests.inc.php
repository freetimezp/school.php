<div class="card-group">
    <table class="table table-striped table-hover">
        <tr>
            <th></th><th>Test name</th><th>Created by</th><th>Active</th><th>Date</th>
            <th>

            </th>
        </tr>

        <?php if(isset($rows) && $rows): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td>
                        <a href="<?=ROOT;?>/single_test/<?=$row->class_id;?>">
                            <button class="btn btn-sm btn-primary">Details <i class="fa fa-chevron-right"></i></button>
                        </a>
                    </td>
                    <td><?=$row->test;?></td><td><?=$row->user->firstname . ' ' . $row->user->lastname;?></td><td><?=$row->disabled?'no':'yes';?></td><td><?=get_date($row->date);?></td>
                    <td>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>No tests</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

