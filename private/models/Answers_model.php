<?php

class Answers_model extends Model
{
    protected $table = 'answers';

    protected $allowedColumns = [
        'user_id',
        'test_id',
        'question_id',
        'answer',
        'date'
    ];

    protected $beforeInsert = [];

    protected $afterSelect = [];

    public function validate($data) {
        $this->errors = [];

        if(count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}