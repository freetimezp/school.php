<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <h4>Students room</h4>
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

        <a href="<?=ROOT;?>/signup?mode=students">
            <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add new</button>
        </a>
    </nav>

    <hr>

    <div class="card-group justify-content-center">
        <?php if($rows): ?>
            <?php foreach ($rows as $row): ?>
                <?php include(views_path('user')); ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div>
                No Students
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$this->view('includes/footer');
?>
