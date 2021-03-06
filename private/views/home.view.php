<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-2 mx-auto shadow home-page">
    <div class="row justify-content-center">

        <?php if(Auth::access('super_admin')): ?>
            <div class="dash-main-item col-2 border rounded m-4 p-0">
                <a href="<?=ROOT;?>/schools" class="dash-main-link">
                    <div class="card-header">SCHOOLS</div>
                    <h1 class="text-center"><i class="fa fa-graduation-cap"></i></h1>
                    <div class="card-footer">View schools</div>
                </a>
            </div>
        <?php endif; ?>

        <?php if(Auth::access('admin')): ?>
            <div class="dash-main-item col-2 border rounded m-4 p-0">
                <a href="<?=ROOT;?>/users" class="dash-main-link">
                    <div class="card-header">STAFF</div>
                    <h1 class="text-center"><i class="fa fa-chalkboard-teacher"></i></h1>
                    <div class="card-footer">View members</div>
                </a>
            </div>
        <?php endif; ?>

        <?php if(Auth::access('reception')): ?>
            <div class="dash-main-item col-2 border rounded m-4 p-0">
                <a href="<?=ROOT;?>/students" class="dash-main-link">
                    <div class="card-header">STUDENTS</div>
                    <h1 class="text-center"><i class="fa fa-user-graduate"></i></h1>
                    <div class="card-footer">View students</div>
                </a>
            </div>
        <?php endif; ?>


        <div class="dash-main-item col-2 border rounded m-4 p-0">
            <a href="<?=ROOT;?>/classes" class="dash-main-link">
                <div class="card-header">CLASSES</div>
                <h1 class="text-center"><i class="fa fa-university"></i></h1>
                <div class="card-footer">View classes</div>
            </a>
        </div>

        <div class="dash-main-item col-2 border rounded m-4 p-0">
            <a href="<?=ROOT;?>/tests" class="dash-main-link">
                <div class="card-header">TESTS</div>
                <h1 class="text-center"><i class="fa fa-file-signature"></i></h1>
                <div class="card-footer">View tests</div>
            </a>
        </div>

        <?php if(Auth::access('admin')): ?>
            <div class="dash-main-item col-2 border rounded m-4 p-0">
                <a href="<?=ROOT;?>/statistics" class="dash-main-link">
                    <div class="card-header">STATISTICS</div>
                    <h1 class="text-center"><i class="fa fa-chart-pie"></i></h1>
                    <div class="card-footer">View statistics</div>
                </a>
            </div>
        <?php endif; ?>


        <?php if(Auth::access('admin')): ?>
            <div class="dash-main-item col-2 border rounded m-4 p-0">
                <a href="<?=ROOT;?>/settings" class="dash-main-link">
                    <div class="card-header">SETTINGS</div>
                    <h1 class="text-center"><i class="fa fa-cogs"></i></h1>
                    <div class="card-footer">View settings</div>
                </a>
            </div>
        <?php endif; ?>

        <div class="dash-main-item col-2 border rounded m-4 p-0">
            <a href="<?=ROOT;?>/logout" class="dash-main-link">
                <div class="card-header">LOGOUT</div>
                <h1 class="text-center"><i class="fa fa-sign-out-alt"></i></h1>
                <div class="card-footer">LOGOUT</div>
            </a>
        </div>

        <div class="dash-main-item col-2 border rounded m-4 p-0">
            <a href="<?=ROOT;?>/profile" class="dash-main-link">
                <div class="card-header">PROFILE</div>
                <h1 class="text-center"><i class="fa fa-id-card"></i></h1>
                <div class="card-footer">View profile</div>
            </a>
        </div>
    </div>
</div>

<?php
$this->view('includes/footer');
?>