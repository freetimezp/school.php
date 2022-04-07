<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
    <div class="container-fluid p-4 profile mx-auto shadow">
        <?php $this->view('includes/crumbs'); ?>
        <a href="<?=ROOT;?>/signup">
            <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></u>Add new</button>
        </a>
        <hr>
        <div class="card-group">
            <?php if($rows): ?>
                <?php foreach ($rows as $row): ?>
                    <div class="card m-2 shadow-lg" style="max-width: 14rem;min-width: 14rem;">
                        <div class="card-header text-center">User profile</div>
                        <img class="card-img-top profile-photo d-block mx-auto" src="<?=ASSETS;?>/img/unknown-user.png" alt="card image user">
                        <div class="card-body">
                            <h5 class="card-title"><?=$row->firstname;?> <?=$row->lastname;?></h5>
                            <p class="card-text">Rank: <?=str_replace("_", " ", $row->rank);?> </p>
                            <a href="#" class="btn btn-primary">Profile</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div>
                    No users
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php
$this->view('includes/footer');
?>