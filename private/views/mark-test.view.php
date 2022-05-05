<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php if($row && !($row->disabled && Auth::access('student'))): ?>
        <h4><?=esc(ucwords($row->test));?> page</h4>

        <div class="row mb-4">
            <div class="col-sm-8 col-md-9 p-2">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Class:</th><td><?=$row->class->class;?></td>
                    </tr>
                    <tr>
                        <th>Student:</th><td><?=$student_row->firstname . ' ' . $student_row->lastname;?></td>
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
                        <th>Active:</th><td><?=$row->disabled?'No':'Yes';?></td>
                    </tr>
                </table>
            </div>
        </div>

        <?php
        switch($page_tab) {
            case 'view':
                include(views_path('mark-test-tab-view'));
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

