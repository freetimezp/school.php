<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs'); ?>
    <h4>Profile</h4>
    <div class="row">
        <div class="col-4">
            <img class="profile-photo rounded-circle d-block mx-auto" src="<?=ASSETS;?>/img/female.png" alt="user photo">
        </div>

        <div class="col p-2">
            <table class="table table-striped table-hover">
                <tr>
                    <th>First Name:</th><td>Mary</td>
                </tr>
                <tr>
                    <th>Last Name:</th><td>Phiri</td>
                </tr>
                <tr>
                    <th>Gender:</th><td>Female</td>
                </tr>
            </table>
        </div>
    </div>

    <div>

    </div>
</div>

<?php
$this->view('includes/footer');
?>