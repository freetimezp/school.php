<div class="card-group">
    <table class="table table-striped table-hover">
        <tr>
            <th></th><th>Test name</th><th>Created by</th><th>Active</th><th>Date</th>
            <th>Answered</th>
            <th></th>
        </tr>

        <?php if(isset($test_rows) && $test_rows): ?>
            <?php foreach ($test_rows as $test_row): ?>
                <?php
                    $bg = '';
                    if(Auth::getRank() == 'student') {
                        if(in_array($test_row->test_id, $unsubmitted)) {
                            $bg = 'style="background: #e1ef62;"';
                        }else{
                            $bg = 'style="background: #84ef6d"';
                        }
                    }
                ?>
                <tr <?=$bg;?>>
                    <td>
                        <?php if(Auth::access('lecturer')): ?>
                            <a href="<?=ROOT;?>/single_test/<?=$test_row->test_id;?>">
                                <button class="btn btn-sm btn-primary">Details <i class="fa fa-chevron-right"></i></button>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?=$test_row->test;?></td><td><?=$test_row->user->firstname . ' ' . $test_row->user->lastname;?></td><td><?=$test_row->disabled?'no':'yes';?></td><td><?=get_date($test_row->date);?></td>
                    <td>
                        <?php
                            $myid = (strtolower(get_class($this)) == 'profile') ? $row->user_id : Auth::getUser_id();
                            $percentage = get_answer_percentage($test_row->test_id, $myid);
                        ?>
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

