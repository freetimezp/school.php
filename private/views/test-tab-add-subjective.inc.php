<h4 class="text-center">Add subjective question</h4>

<form method="post" enctype="multipart/form-data">
    <?php if(count($errors) > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Errors:</strong><br>
            <?php foreach ($errors as $error): ?>
                <?=$error . "<br>"; ?>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <label class="mb-1">Question:</label>
    <textarea class="form-control mb-3" name="question" placeholder="Type your question here"></textarea>

    <label class="mb-1">Upload your image for question if you need:</label>
    <div class="input-group mb-3">
        <label class="input-group-text btn-success" for="inputGroupFile01"><i class="fa fa-image"></i>Image</label>
        <input type="file" class="form-control" id="inputGroupFile01">
    </div>

    <div class="text-center">
        <button class="btn btn-primary">Save</button>
        <a href="<?=ROOT;?>/single_test/<?=$row->test_id;?>">
            <button type="button" class="btn btn-secondary">Cancel</button>
        </a>
    </div>
</form>
