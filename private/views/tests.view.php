<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <h4>Tests room</h4>
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <nav class="navbar navbar-light bg-light">
        <form class="form-inline">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp;</button>
                </div>
                <input value="<?=isset($_GET['find'])?$_GET['find']:'';?>" name="find" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
            </div>
        </form>

        <?php if(Auth::access('lecturer')): ?>
            <a href="<?=ROOT;?>/tests/add">
                <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add new</button>
            </a>
        <?php endif; ?>
    </nav>

    <?php include (views_path('tests')); ?>

</div>

<?php
$this->view('includes/footer');
?>

