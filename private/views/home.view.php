<?php
$this->view('includes/header');
$this->view('includes/nav');
?>

    <div class="container-fluid">
        <i class="fa fa-plus"></i>
        <h1>this is home view page</h1>
    </div>
    <div>
        <?php
            echo '<pre>';
            print_r($rows);
        ?>
    </div>
<?php
$this->view('includes/footer');
?>