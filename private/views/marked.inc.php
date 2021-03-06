<div class="card-group">
    <table class="table table-striped table-hover">
        <tr>
            <th>Test name</th><th>Class</th>
            <th>Student</th><th>Date submitted</th>
            <th>Marked by</th>
            <th>Date marked</th>
            <th>Answered</th>
            <th>Score</th>
            <th></th>
        </tr>

        <?php if(isset($test_rows) && $test_rows): ?>
            <?php foreach ($test_rows as $test_row): ?>
                <tr class="align-middle">
                    <td><?=$test_row->test_details->test;?></td>
                    <td><?=$test_row->test_details->class->class;?></td>
                    <td><?=$test_row->user->firstname . ' ' . $test_row->user->lastname;?></td>
                    <td><?=get_date($test_row->submitted_date);?></td>
                    <td>
                        <?php
                            $user = new User();
                            $my_marker = $user->first('user_id', $test_row->marked_by);
                            if($my_marker) {
                                echo $my_marker->firstname . ' ' . $my_marker->lastname;
                            }
                        ?>
                    </td>
                    <td><?=get_date($test_row->marked_date);?></td>
                    <td>
                        <?php $percentage = get_answer_percentage($test_row->test_details->test_id, $test_row->user->user_id); ?>
                        <span><?=$percentage . ' %';?></span>
                    </td>
                    <td>
                        <?=get_score_percentage($test_row->test_id, $test_row->user_id).' %'; ?>
                    </td>
                    <td>
                        <a href="<?=ROOT;?>/marked_single/<?=$test_row->test_id;?>/<?=$test_row->user->user_id;?>">
                            <button class="btn btn-primary">View</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>No tests</td>
            </tr>
        <?php endif; ?>
    </table>
</div>



