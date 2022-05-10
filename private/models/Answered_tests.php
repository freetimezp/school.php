<?php

class Answered_tests extends Model
{
    protected $table = 'answered_tests';

    protected $allowedColumns = [];

    protected $beforeInsert = [];

    protected $afterSelect = [
        'get_user'
    ];

    public function make_user_id($data) {
        if(isset($_SESSION['USER']->user_id)) {
            $data['user_id'] = $_SESSION['USER']->user_id;
        }

        return $data;
    }

    public function get_user($data) {
        $user = new User();

        foreach ($data as $key => $row) {
            $result = $user->where("user_id", $row->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
        }

        return $data;
    }
}
