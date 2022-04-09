<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

    <div class="container-fluid p-4 profile mx-auto shadow">
        <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

        <?php if($row): ?>
            <h4><?=esc(ucwords($row->class));?> page</h4>

            <div class="row mb-4">
                <div class="col-sm-8 col-md-9 p-2">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Class Name:</th><td><?=esc($row->class);?></td>
                        </tr>
                        <tr>
                            <th>Created by:</th><td><?=esc($row->user->firstname);?> <?=esc($row->user->lastname);?></td>
                        </tr>
                        <tr>
                            <th>Date Created:</th><td><?=get_date($row->date);?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?=$page_tab=='lecturers'?'active':'';?>" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=lecturers">Lecturers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$page_tab=='students'?'active':'';?>" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=students">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$page_tab=='tests'?'active':'';?>" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests">Tests</a>
                </li>
            </ul>

            <nav class="navbar navbar-light bg-light">
                <form class="form-inline">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp;</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </form>
            </nav>

        <?php else: ?>
            <h4>That class was not found!</h4>
        <?php endif; ?>
    </div>

<?php
$this->view('includes/footer');
?>