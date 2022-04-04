<?php
$this->view('includes/header');
$this->view('includes/nav');
?>
<div class="container-fluid p-4 profile mx-auto shadow">
    <?php $this->view('includes/crumbs'); ?>
    <div class="card-group">
        <table class="table table-striped table-hover">
            <tr>
                <th>School</th><th>Created by</th><th>Date</th>
                <th>
                    <a href="<?=ROOT;?>/schools/add">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></u>Add new</button>
                    </a>
                </th>
            </tr>
        </table>

        <?php if($rows): ?>
            <?php foreach ($rows as $row): ?>

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
