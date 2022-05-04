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
            <li class="nav-item active">
                <a class="nav-link" href="<?=ROOT;?>">DASHBOARD</a>
            </li>

            <?php if(Auth::access('super_admin')): ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?=ROOT?>/schools">SCHOOLS</a>
                </li>
            <?php endif; ?>

            <?php if(Auth::access('admin')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/users">STAFF</a>
                </li>
            <?php endif; ?>

            <?php if(Auth::access('reception')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/students">STUDENTS</a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="<?=ROOT?>/classes">CLASSES</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?=ROOT?>/tests">TESTS</a>
            </li>

            <?php if(Auth::access('lecturer')): ?>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="<?=ROOT?>/to_mark">TESTS TO MARK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/marked">MARKED TESTS</a>
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
    </div>
</nav>


