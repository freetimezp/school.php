<?php

class Questions_model extends Model
{
    protected $table = 'tests_questions';

    protected $allowedColumns = [
        'question',
        'date',
        'question_type',
        'test_id',
        'correct_answer',
        'choices',
        'image'
    ];

    protected $beforeInsert = [
        'make_user_id'
    ];

    protected $afterSelect = [
        'get_user'
    ];

    public function validate($data) {
        $this->errors = array();
        //[a-z A-Z0-9]  allowed letters, numbers and spaces; if [a-zA-Z] - allowed only letters
        if(empty($data['question'])) {
            $this->errors['question'] = "You must add question name!";
        }

        if(count($this->errors) == 0) {
            return true;
        }

        return false;
    }

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