<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php if($row): ?>
        <h4><?=esc(ucwords($row->test));?></h4>

        <div class="row mb-4">
            <div class="col-sm-8 col-md-9 p-2">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Go to class:</th>
                        <td>
                            <a href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests">
                                <button class="btn btn-sm btn-success">VIEW CLASS</button>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>See all scores:</th>
                        <td>
                            <a href="<?=ROOT;?>/single_test/<?=$row->test_id;?>?tab=scores">
                                <button class="btn btn-sm btn-success">VIEW SCORES</button>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Test Name:</th><td><?=esc($row->test);?></td>
                    </tr>
                    <tr>
                        <th>Description:</th><td><?=esc($row->description);?></td>
                    </tr>
                    <tr>
                        <th>Total questions:</th><td><?=$total_questions;?></td>
                    </tr>
                    <tr>
                        <th>Created by:</th><td><?=esc($row->user->firstname);?> <?=esc($row->user->lastname);?></td>
                    </tr>
                    <tr>
                        <th>Date Created:</th><td><?=get_date($row->date);?></td>
                    </tr>
                    <tr>
                        <th>Published:</th>
                        <td>
                            <span class="me-2"><?=$row->disabled?'No':'Yes';?></span>
                            <a href="<?=ROOT;?>/single_test/<?=$row->test_id?>?disable=true">
                                <?php if($row->disabled): ?>
                                    <button class="btn btn-sm btn-success p-0">Publish</button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-danger p-0">Unpublish</button>
                                <?php endif; ?>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php
            switch($page_tab) {
                case 'view':
                    include(views_path('test-tab-view'));
                    break;
                case 'add-question':
                    include(views_path('test-tab-add-question'));
                    break;
                case 'edit-question':
                    include(views_path('test-tab-edit-question'));
                    break;
                case 'delete-question':
                    include(views_path('test-tab-delete-question'));
                    break;
                case 'edit':
                    include(views_path('test-tab-edit'));
                    break;
                case 'delete':
                    include(views_path('test-tab-delete'));
                    break;
                case 'scores':
                    include(views_path('test-tab-scores'));
                    break;
                default:
                    break;
            }
        ?>

    <?php else: ?>
        <h4>That test was not found!</h4>
    <?php endif; ?>
</div>

<?php $this->view('includes/footer'); ?>
