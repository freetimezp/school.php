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
                <?php if(Auth::access('lecturer')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?=$page_tab=='lecturers'?'active':'';?>" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=lecturers">Lecturers</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?=$page_tab=='students'?'active':'';?>" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=students">Students</a>
                </li>
                <?php if(Auth::access('lecturer')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?=$page_tab=='tests'?'active':'';?>" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests">Tests</a>
                    </li>
                <?php endif; ?>
            </ul>

            <?php
                switch($page_tab) {
                    case 'lecturers':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-lecturers'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'lecturer-add':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-lecturers-add'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'lecturer-remove':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-lecturers-remove'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'students':
                        include(views_path('class-tab-students'));
                        break;
                    case 'student-add':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-students-add'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'student-remove':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-students-remove'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'tests':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-tests'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'test-add':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-tests-add'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'test-edit':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-tests-edit'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'test-delete':
                        if(Auth::access('lecturer')) {
                            include(views_path('class-tab-tests-delete'));
                        }else{
                            include(views_path('access-denied'));
                        }
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