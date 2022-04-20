<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-4 profile mx-auto shadow">
    <h4 class="text-center">Edit profile</h4>
    <?php if($row): ?>
        <?php $image = get_image($row->image, $row->gender); ?>

        <div class="row mb-4">
            <div class="col-sm-4 col-md-3">
                <img class="profile-photo rounded-circle d-block mx-auto" src="<?=$image;?>" alt="user photo">

                <hr class="clearfix">

                <?php if(Auth::access('reception') || Auth::i_own_content($row)): ?>
                    <div class="text-center">
                        <button class="btn btn-sm btn-success">Browse image</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-sm-8 col-md-9 p-2">
                <form method="post">
                    <div class="mx-auto shadow rounded p-2">

                        <?php if(count($errors) > 0): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Errors:</strong><br>
                                <?php foreach ($errors as $error): ?>
                                    <?=$error . "<br>"; ?>
                                <?php endforeach; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <input class="form-control mb-2" value="<?=get_var('firstname', $row->firstname);?>" type="text" name="firstname" placeholder="firstname">
                        <input class="form-control mb-2" value="<?=get_var('lastname', $row->lastname);?>" type="text" name="lastname" placeholder="lastname">
                        <input class="form-control mb-2" value="<?=get_var('email', $row->email);?>" type="text" name="email" placeholder="email@email.ua">

                        <select class="form-control mb-2" name="gender">
                            <option <?=get_select('gender', $row->gender);?> value="<?=$row->gender;?>"><?=ucwords($row->gender);?></option>
                            <option <?=get_select('gender', 'male');?> value="male">Male</option>
                            <option <?=get_select('gender', 'female');?> value="female">Female</option>
                        </select>

                        <select class="form-control mb-2" name="rank">
                            <option <?=get_select('rank', $row->rank);?> value="<?=$row->rank;?>"><?=ucwords($row->rank);?></option>
                            <option <?=get_select('rank', 'student');?> value="student">Student</option>
                            <option <?=get_select('rank', 'reception');?> value="reception">Reception</option>
                            <option <?=get_select('rank', 'lecturer');?> value="lecturer">Lecturer</option>
                            <option <?=get_select('rank', 'admin');?> value="admin">Admin</option>

                            <?php if(Auth::getRank() == 'super_admin'): ?>
                                <option <?=get_select('rank', 'super_admin');?> value="super_admin">Super Admin</option>
                            <?php endif; ?>

                        </select>


                        <input class="form-control mb-2" value="<?=get_var('password');?>" type="text" name="password" placeholder="password">
                        <input class="form-control mb-2" value="<?=get_var('password2');?>" type="text" name="password2" placeholder="retype password">

                        <div class="text-center">
                            <button class="btn btn-sm btn-primary">Save</button>
                            <a href="<?=ROOT;?>/profile/<?=$row->user_id;?>">
                                <button type="button" class="btn btn-sm btn-secondary">Cancel</button>
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    <?php else: ?>
        <h4>That profile was not found!</h4>
    <?php endif; ?>
</div>

<?php
$this->view('includes/footer');
?>
