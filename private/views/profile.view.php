<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php if($row): ?>
        <?php
            $image = get_image($row->image, $row->gender);
        ?>
        <h4>Profile</h4>
        <div class="row mb-4">
            <div class="col-sm-4 col-md-3">
                <img class="profile-photo rounded-circle d-block mx-auto" src="<?=$image;?>" alt="user photo">
                <h3 class="text-center"><?=esc($row->firstname);?> <?=esc($row->lastname);?></h3>

                <hr class="clearfix">

                <?php if(Auth::access('admin') || (Auth::access('reception') && $row->rank == 'student')): ?>
                    <div class="text-center">
                        <a href="<?=ROOT;?>/profile/edit/<?=$row->user_id;?>">
                            <button class="btn btn-sm btn-success">Edit</button>
                        </a>
                        <a href="<?=ROOT;?>/profile/delete/<?=$row->user_id;?>">
                            <button class="btn btn-sm btn-warning">Delete</button>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-sm-8 col-md-9 p-2">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>First Name:</th><td><?=esc($row->firstname);?></td>
                    </tr>
                    <tr>
                        <th>Last Name:</th><td><?=esc($row->lastname);?></td>
                    </tr>
                    <tr>
                        <th>Gender:</th><td><?=esc($row->gender);?></td>
                    </tr>
                    <tr>
                        <th>Email:</th><td><?=esc($row->email);?></td>
                    </tr>
                    <tr>
                        <th>Rank:</th><td><?=ucfirst(str_replace("_", " ", $row->rank));?></td>
                    </tr>
                    <tr>
                        <th>Date Created:</th><td><?=get_date($row->date);?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="container-fluid">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?=$page_tab=='info'?'active':'';?>" href="<?=ROOT;?>/profile/<?=$row->user_id;?>?tab=info">Basic Info</a>
                </li>

                <?php if(Auth::access('lecturer') || Auth::i_own_content($row)): ?>
                    <li class="nav-item">
                        <a class="nav-link <?=$page_tab=='classes'?'active':'';?>" href="<?=ROOT;?>/profile/<?=$row->user_id;?>?tab=classes">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?=$page_tab=='tests'?'active':'';?>" href="<?=ROOT;?>/profile/<?=$row->user_id;?>?tab=tests">Tests</a>
                    </li>
                <?php endif; ?>
            </ul>

            <?php
                switch ($page_tab) {
                    case 'info':
                        include(views_path('profile-tab-info'));
                        break;
                    case 'classes':
                        if(Auth::access('lecturer') || Auth::i_own_content($row)) {
                            include(views_path('profile-tab-classes'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    case 'tests':
                        if(Auth::access('lecturer') || Auth::i_own_content($row)) {
                            include(views_path('profile-tab-tests'));
                        }else{
                            include(views_path('access-denied'));
                        }
                        break;
                    default:
                        break;
                }
            ?>

        </div>
    <?php else: ?>
        <h4>That profile was not found!</h4>
    <?php endif; ?>
</div>

<?php
$this->view('includes/footer');
?>