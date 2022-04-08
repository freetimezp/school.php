<?php
$this->view('includes/header');
?>

<div class="container-fluid">
    <form method="post">
        <div style="width: 100%;max-width: 340px;" class="mx-auto shadow rounded mt-5 p-4">
            <h2 class="text-center">My School</h2>
            <img src="<?=ROOT?>/assets/img/logo.png" alt="my school" class="rounded d-block mx-auto" style="width: 90px;">
            <h3>Add User</h3>

            <?php if(count($errors) > 0): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Errors:</strong><br>
                    <?php foreach ($errors as $error): ?>
                        <?=$error . "<br>"; ?>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>


            <input class="form-control mb-2" value="<?=get_var('firstname');?>" type="text" name="firstname" placeholder="firstname">
            <input class="form-control mb-2" value="<?=get_var('lastname');?>" type="text" name="lastname" placeholder="lastname">
            <input class="form-control mb-2" value="<?=get_var('email');?>" type="text" name="email" placeholder="email@email.ua">

            <select class="form-control mb-2" name="gender">
                <option <?=get_select('gender', '');?> value="">--Select a Gender--</option>
                <option <?=get_select('gender', 'male');?> value="male">Male</option>
                <option <?=get_select('gender', 'female');?> value="female">Female</option>
            </select>

            <?php if($mode == 'students'): ?>
                <input type="hidden" value="student" name="rank">
            <?php else: ?>
                <select class="form-control mb-2" name="rank">
                    <option <?=get_select('rank', '');?> value="">--Select a Rank--</option>
                    <option <?=get_select('rank', 'student');?> value="student">Student</option>
                    <option <?=get_select('rank', 'reception');?> value="reception">Reception</option>
                    <option <?=get_select('rank', 'lecturer');?> value="lecturer">Lecturer</option>
                    <option <?=get_select('rank', 'admin');?> value="admin">Admin</option>

                    <?php if(Auth::getRank() == 'super_admin'): ?>
                        <option <?=get_select('rank', 'super_admin');?> value="super_admin">Super Admin</option>
                    <?php endif; ?>

                </select>
            <?php endif; ?>

            <input class="form-control mb-2" value="<?=get_var('password');?>" type="text" name="password" placeholder="password">
            <input class="form-control mb-2" value="<?=get_var('password2');?>" type="text" name="password2" placeholder="retype password">
            <br>
            <button type="submit" class="btn btn-primary">Add User</button>

            <?php if($mode == 'students'): ?>
                <a href="<?=ROOT;?>/students">
                    <button type="button" class="btn btn-dark">Cancel</button>
                </a>
            <?php else: ?>
                <a href="<?=ROOT;?>/users">
                    <button type="button" class="btn btn-dark">Cancel</button>
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php
$this->view('includes/footer');
?>

