<div>
    <a href="<?=ROOT;?>/single_test/<?=$row->test_id;?>">
        <button class="btn btn-sm btn-secondary">Back</button>
    </a>
    <span>*to this test questions</span>
    <hr>
    <h4>Scores for this test</h4>
    <table class="table table-striped table-hover">
        <tr>
            <th>Student</th>
            <th>Score</th>
        </tr>

        <?php if($student_scores): ?>
            <?php foreach ($student_scores as $key => $score): ?>
                <tr>
                    <td><?=$score->user->firstname;?> <?=$score->user->lastname;?></td>
                    <td><?=$score->score;?> %</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <span>No marked tests yet!</span>
            </tr>
        <?php endif; ?>
    </table>
</div>