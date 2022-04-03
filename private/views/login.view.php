<?php
$this->view('includes/header');
?>

<div class="container-fluid">
    <form method="post">
        <div style="width: 100%;max-width: 340px;" class="mx-auto shadow rounded mt-5 p-4">
            <h2 class="text-center">My School</h2>
            <img src="<?=ROOT?>/assets/img/logo.png" alt="my school" class="rounded d-block mx-auto" style="width: 90px;">
            <h3>Login</h3>

            <?php if(count($errors) > 0): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Errors:</strong><br>
                    <?php foreach ($errors as $error): ?>
                        <?=$error . "<br>"; ?>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <input class="form-control mb-2" value="<?=get_var('email');?>" type="email" name="email" placeholder="email@email.ua">
            <input class="form-control" value="<?=get_var('password');?>" type="password" name="password" placeholder="password">
            <br>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</div>

<?php
$this->view('includes/footer');
?>
