<div>
    <h4 class="text-center">Test questions</h4>

    <nav class="navbar">
        <div class="btn-group">
            <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bars"></i>Add
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests">
                        Add multiple choice question
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests">
                        Add objective question
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="<?=ROOT;?>/single_class/<?=$row->class_id;?>?tab=tests">
                        Add subjective question
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
