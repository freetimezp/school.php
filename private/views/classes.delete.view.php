<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php if($row): ?>
        <div class="card-group">
            <form method="post">
                <h4>Are you sure you want to delete class?</h4>

                <input disabled class="form-control" value="<?=get_var('class', $row[0]->class);?>" type="text" name="class" placeholder="Class name">
                <br>

                <input type="hidden" name="id">
                <input class="btn btn-danger float-end" type="submit" value="Delete">

                <a href="<?=ROOT;?>/classes">
                    <input class="btn btn-secondary text-white" type="button" value="Cancel">
                </a>
            </form>
        </div>
    <?php else: ?>
        <div class="card-group d-block">
            <span class="mb-4 d-block">That class was not found!</span>

            <a href="<?=ROOT;?>/classes">
                <input class="btn btn-secondary text-white" type="button" value="Cancel">
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
$this->view('includes/footer');
?>



