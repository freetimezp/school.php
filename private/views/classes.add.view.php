<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>
    <div class="card-group">
        <form method="post">
            <h4>Create new class</h4>

            <?php if(count($errors) > 0): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Errors:</strong><br>
                    <?php foreach ($errors as $error): ?>
                        <?=$error . "<br>"; ?>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <input autofocus class="form-control" value="<?=get_var('class');?>" type="text" name="class" placeholder="Class name">
            <br>

            <input class="btn btn-primary float-end" type="submit" value="Create">

            <a href="<?=ROOT;?>/classes">
                <input class="btn btn-secondary text-white" type="button" value="Cancel">
            </a>
        </form>
    </div>
</div>

<?php
$this->view('includes/footer');
?>

