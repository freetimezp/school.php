<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <h4>Classes room</h4>
    <?php $this->view('includes/crumbs',['crumbs' => $crumbs]); ?>

    <?php include (views_path('classes')); ?>

</div>

<?php
$this->view('includes/footer');
?>
