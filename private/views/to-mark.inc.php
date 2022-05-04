<div class="card-group">
    <table class="table table-striped table-hover">
        <tr>
            <th></th><th>Test name</th><th>Class</th><th>Student</th><th>Date submitted</th>
            <th>Answered</th>
            <th></th>
        </tr>

        <?php if(isset($test_rows) && $test_rows): ?>
            <?php foreach ($test_rows as $test_row): ?>
                <tr>
                    <td>
                        <?php if(Auth::access('lecturer')): ?>
                            <a href="<?=ROOT;?>/single_test/<?=$test_row->test_id;?>">
                                <button class="btn btn-sm btn-primary">Mark test <i class="fa fa-chevron-right"></i></button>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?=$test_row->test_details->test;?></td>
                    <td><?=$test_row->test_details->class->class;?></td>
                    <td><?=$test_row->user->firstname . ' ' . $test_row->user->lastname;?></td>
                    <td><?=get_date($test_row->test_details->submitted_date);?></td>
                    <td>
                        <?php $percentage = get_answer_percentage($test_row->test_id, $test_row->user_id); ?>
                        <span><?=$percentage . ' %';?></span>
                    </td>
                    <td>
                        <?php if(can_take_test($test_row->test_id)): ?>
                            <a href="<?=ROOT;?>/take_test/<?=$test_row->test_id;?>">
                                <button class="btn btn-sm btn-primary">Start test</button>
                            </a>
                        <?php endif; ?>
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


