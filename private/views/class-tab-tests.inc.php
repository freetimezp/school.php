<nav class="navbar navbar-light bg-light">
    <form class="form-inline">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp;</span>
            </div>
            <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
        </div>
    </form>

    <a href="<?=ROOT;?>/single_class/testadd/<?=$row->class_id;?>?tab=test-add">
        <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add test</button>
    </a>
</nav>

<div class="card-group">
    <table class="table table-striped table-hover">
        <tr>
            <th></th><th>Test name</th><th>Created by</th><th>Active</th><th>Date</th>
            <th></th>
        </tr>

        <?php if(isset($tests) && $tests): ?>
            <?php foreach ($tests as $row): ?>
                <tr>
                    <td>
                        <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>">
                            <button class="btn btn-sm btn-primary">Details <i class="fa fa-chevron-right"></i></button>
                        </a>
                    </td>
                    <td><?=$row->test;?></td><td><?=$row->user->firstname . ' ' . $row->user->lastname;?></td><td><?=$row->disabled?'no':'yes';?></td><td><?=get_date($row->date);?></td>
                    <td>
                        <?php if(Auth::access('lecturer')): ?>
                            <a href="<?=ROOT;?>/single_class/testedit/<?=$row->id;?>?tab=tests">
                                <button class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></button>
                            </a>
                            <a href="<?=ROOT;?>/single_class/testdelete/<?=$row->id;?>?tab=tests">
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button>
                            </a>
                        <?php endif; ?>
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

