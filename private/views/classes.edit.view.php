<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php if($row): ?>
        <div class="card-group">
            <form method="post">
                <h4>Edit school</h4>

                <?php if(count($errors) > 0): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Errors:</strong><br>
                        <?php foreach ($errors as $error): ?>
                            <?=$error . "<br>"; ?>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <input autofocus class="form-control" value="<?=get_var('school', $row[0]->school);?>" type="text" name="school" placeholder="School name">
                <br>

                <input class="btn btn-primary float-end" type="submit" value="Save">

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


