<?php
$this->view('includes/header');
?>

<?php
    echo '<pre>';
    print_r($errors);
?>

<div class="container-fluid">
    <form method="post">
        <div style="width: 100%;max-width: 340px;" class="mx-auto shadow rounded mt-5 p-4">
            <h2 class="text-center">My School</h2>
            <img src="<?=ROOT?>/assets/img/logo.png" alt="my school" class="rounded d-block mx-auto" style="width: 90px;">
            <h3>Add User</h3>
            <input class="form-control mb-2" type="text" name="firstname" placeholder="firstname">
            <input class="form-control mb-2" type="text" name="lastname" placeholder="lastname">
            <input class="form-control mb-2" type="email" name="email" placeholder="email@email.ua">

            <select class="form-control mb-2" name="gender">
                <option value="">--Select a Gender--</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <select class="form-control mb-2" name="rank">
                <option value="">--Select a Rank--</option>
                <option value="student">Student</option>
                <option value="reception">Reception</option>
                <option value="lecturer">Lecturer</option>
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>

            <input class="form-control mb-2" type="text" name="password" placeholder="password">
            <input class="form-control mb-2" type="text" name="password2" placeholder="retype password">
            <br>
            <button type="submit" class="btn btn-primary">Add User</button>
            <button type="button" class="btn btn-dark">Cancel</button>
        </div>
    </form>
</div>

<?php
$this->view('includes/footer');
?>

