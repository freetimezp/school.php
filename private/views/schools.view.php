<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs'); ?>
    <div class="card-group">
        <?php if($rows): ?>
            <?php foreach ($rows as $row): ?>
                <div class="card m-2 shadow-lg" style="max-width: 14rem;min-width: 14rem;">
                    <div class="card-header text-center">School profile</div>
                    <img class="card-img-top profile-photo d-block mx-auto" src="<?=ASSETS;?>/img/unknown-user.png" alt="card image user">
                    <div class="card-body">
                        <h5 class="card-title"><?=$row->school;?></h5>
                        <p class="card-text">Date: </p>
                        <a href="#" class="btn btn-primary">Profile</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div>
                No schools
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$this->view('includes/footer');
?>
