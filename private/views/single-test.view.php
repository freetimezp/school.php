<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php if($row): ?>
        <h4><?=esc(ucwords($row->test));?> page</h4>

        <div class="row mb-4">
            <div class="col-sm-8 col-md-9 p-2">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Test Name:</th><td><?=esc($row->test);?></td>
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

        <?php
            switch($page_tab) {
                case 'view':
                    include(views_path('test-tab-view'));
                    break;
                case 'add':
                    include(views_path('test-tab-add'));
                    break;
                case 'edit':
                    include(views_path('test-tab-edit'));
                    break;
                case 'delete':
                    include(views_path('test-tab-delete'));
                    break;
                default:
                    break;
            }
        ?>

    <?php else: ?>
        <h4>That test was not found!</h4>
    <?php endif; ?>
</div>

<?php
$this->view('includes/footer');
?>
