<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs'); ?>
    <h4>Profile</h4>
    <div class="row mb-4">
        <div class="col-sm-4 col-md-3">
            <img class="profile-photo rounded-circle d-block mx-auto" src="<?=ASSETS;?>/img/female.png" alt="user photo">
            <h3 class="text-center">Mary Phiri</h3>
        </div>

        <div class="col-sm-8 col-md-9 p-2">
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
                <tr>
                    <th>Date Created:</th><td>29.03.2022</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Basic Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Classes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Tests</a>
            </li>
        </ul>

        <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp;</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>
        </nav>
    </div>
</div>

<?php
$this->view('includes/footer');
?>