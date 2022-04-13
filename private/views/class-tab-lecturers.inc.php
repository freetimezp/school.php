<nav class="navbar navbar-light bg-light">
    <form class="form-inline">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp;</span>
            </div>
            <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
        </div>
    </form>

    <div>
        <a href="<?=ROOT;?>/single_class/lectureradd/<?=$row->class_id;?>?select=true">
            <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add new</button>
        </a>
        <a href="<?=ROOT;?>/single_class/lecturerremove/<?=$row->class_id;?>?select=true">
            <button class="btn btn-sm btn-danger"><i class="fa fa-minus"></i>Remove</button>
        </a>
    </div>
</nav>

<div class="card-group justify-content-center">
    <?php if(is_array($lecturers)): ?>
        <?php foreach ($lecturers as $lecturer): ?>
            <?php $row = $lecturer->user; ?>
            <?php include (views_path('user')); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <h5>No lectures are selected to this class.</h5>
    <?php endif; ?>
</div>
