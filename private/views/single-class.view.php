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

            <?php
                switch($page_tab) {
                    case 'lecturers':
                        include(views_path('class-tab-lecturers'));
                        break;
                    case 'students':
                        include(views_path('class-tab-students'));
                        break;
                    case 'tests':
                        include(views_path('class-tab-tests'));
                        break;
                    case 'lecturer-add':
                        include(views_path('class-tab-lecturers-add'));
                        break;
                    case 'lecturer-remove':
                        include(views_path('class-tab-lecturers-remove'));
                        break;
                    case 'student-add':
                        include(views_path('class-tab-students-add'));
                        break;
                    case 'test-add':
                        include(views_path('class-tab-tests-add'));
                        break;
                    default:
                        break;
                }
            ?>

        <?php else: ?>
            <h4>That class was not found!</h4>
        <?php endif; ?>
    </div>

<?php
$this->view('includes/footer');
?>