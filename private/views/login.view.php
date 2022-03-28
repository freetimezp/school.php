<?php
$this->view('includes/header');
?>

<div class="container-fluid">
    <div style="width: 100%;max-width: 340px;" class="mx-auto shadow rounded mt-5 p-4">
        <h2 class="text-center">My School</h2>
        <img src="<?=ROOT?>/assets/img/logo.png" alt="my school" class="rounded d-block mx-auto" style="width: 90px;">
        <h3>Login</h3>
        <input class="form-control mb-2" type="email" name="email" placeholder="email@email.ua">
        <input class="form-control" type="password" name="password" placeholder="password">
        <br>
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
</div>

<?php
$this->view('includes/footer');
?>
