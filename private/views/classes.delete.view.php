<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php if($row): ?>
        <div class="card-group">
            <form method="post">
                <h4>Are you sure you want to delete school?</h4>

                <input disabled class="form-control" value="<?=get_var('school', $row[0]->school);?>" type="text" name="school" placeholder="School name">
                <br>

                <input type="hidden" name="id">
                <input class="btn btn-danger float-end" type="submit" value="Delete">

                <a href="<?=ROOT;?>/schools">
                    <input class="btn btn-secondary text-white" type="button" value="Cancel">
                </a>
            </form>
        </div>
    <?php else: ?>
        <div class="card-group d-block">
            <span class="mb-4 d-block">That school was not found!</span>

            <a href="<?=ROOT;?>/schools">
                <input class="btn btn-secondary text-white" type="button" value="Cancel">
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
$this->view('includes/footer');
?>



