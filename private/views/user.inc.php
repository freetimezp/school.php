<?php
$image = get_image($row->image, $row->gender);
?>
<div class="card m-2 shadow-lg" style="max-width: 14rem;min-width: 14rem;">
    <div class="card-header text-center">User profile</div>
    <img class="card-img-top profile-photo d-block mx-auto" src="<?=$image;?>" alt="card image user">
    <div class="card-body">
        <h5 class="card-title"><?=$row->firstname;?> <?=$row->lastname;?></h5>
        <p class="card-text">Rank: <?=str_replace("_", " ", $row->rank);?> </p>
        <a href="<?=ROOT;?>/profile/<?=$row->user_id;?>" class="btn btn-primary">Profile</a>
    </div>
</div>
