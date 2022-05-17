<nav class="navbar navbar-expand-lg navbar-light bg-light p-3">
    <a class="navbar-brand" href="<?=ROOT;?>">
        <img src="<?=ROOT;?>/assets/img/logo.png" alt="my school" style="width: 90px;">
        <?=Auth::getSchool_name(); ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?=($this->controller_name() == 'Home')?'active bg-secondary text-white':'';?>" href="<?=ROOT;?>">DASHBOARD</a>
            </li>

            <?php if(Auth::access('super_admin')): ?>
                <li class="nav-item">
                    <a class="nav-link  <?=($this->controller_name() == 'Schools')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/schools">SCHOOLS</a>
                </li>
            <?php endif; ?>

            <?php if(Auth::access('admin')): ?>
                <li class="nav-item">
                    <a class="nav-link  <?=($this->controller_name() == 'Users')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/users">STAFF</a>
                </li>
            <?php endif; ?>

            <?php if(Auth::access('reception')): ?>
                <li class="nav-item">
                    <a class="nav-link <?=($this->controller_name() == 'Students')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/students">STUDENTS</a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link <?=($this->controller_name() == 'Classes')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/classes">CLASSES</a>
            </li>

            <?php if(Auth::getRank() == 'student'): ?>
                <li class="nav-item">
                    <a class="nav-link <?=($this->controller_name() == 'Tests')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/tests">
                        <span>TESTS</span>
                        <?php
                            $tests = new Tests_model();
                            $to_submit_count = get_unsubmitted_test();
                        ?>
                        <?php if($to_submit_count): ?>
                            <span class="badge text-white border rounded-circle border-primary bg-primary"><?=$to_submit_count;?></span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link <?=($this->controller_name() == 'Tests')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/tests">TESTS</a>
                </li>
            <?php endif; ?>

            <?php if(Auth::access('lecturer')): ?>
                <li class="nav-item">
                    <a class="nav-link <?=($this->controller_name() == 'To_mark')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/to_mark">
                        <span>TO MARK</span>
                        <?php
                            $tests = new Tests_model();
                            $to_mark_count = $tests->get_to_mark_count();
                        ?>
                        <?php if($to_mark_count): ?>
                            <span class="badge text-white border rounded-circle border-primary bg-primary"><?=$to_mark_count;?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=($this->controller_name() == 'Marked')?'active bg-secondary text-white':'';?>" href="<?=ROOT?>/marked">MARKED</a>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=Auth::getFirstname(); ?>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?=ROOT?>/profile">Profile</a>
                    <a class="dropdown-item" href="<?=ROOT?>">Dashboard</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=ROOT?>/logout">Logout</a>
                </div>
            </li>
        </ul>

        <form class="form-inline ms-1">
            <div class="input-group">
                <?php $years = get_years(); ?>
                <select name="school_year" class="form-select me-1">
                    <?php if($years): ?>
                        <option><?=get_var(
                                'school_year',
                                !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time()),
                                'get');?>
                        </option>
                        <?php $selected_year = $_SESSION['SCHOOL_YEAR']->year; ?>
                        <?php foreach($years as $key => $year): ?>
                            <option class="<?=($selected_year == $year)?'bg-warning':'';?>"><?=$year;?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <?=add_get_vars();?>

                <div class="input-group-prepend">
                    <button class="input-group-text p-2 bg-success text-white">GO</button>
                </div>
            </div>
        </form>
    </div>
</nav>


