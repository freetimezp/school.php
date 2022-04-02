<?php

class User extends Model
{
    public function validate($data) {
        $this->errors = array();

        if(empty($data['firstname']) || !preg_match('/^[a-zA-Z]+$/', $data['firstname'])) {
            $this->errors['firstname'] = "Only letters allowed in first name!";
        }

        if(empty($data['lastname']) || !preg_match('/^[a-zA-Z]+$/', $data['lastname'])) {
            $this->errors['lastname'] = "Only letters allowed in last name!";
        }

        if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid!";
        }

        $genders = ['female', 'male'];
        if(empty($data['gender']) || !in_array($data['gender'], $genders)) {
            $this->errors['gender'] = "Gender is not valid!";
        }

        $ranks = ['student', 'reception', 'lecturer', 'admin', 'super_admin'];
        if(empty($data['rank']) || !in_array($data['rank'], $ranks)) {
            $this->errors['rank'] = "Rank is not valid!";
        }

        if(empty($data['password']) || $data['password'] != $data['password2']) {
            $this->errors['password'] = "The passwords do not match!";
        }

        if(strlen($data['password']) < 10) {
            $this->errors['password'] = "Password must be at least 10 symbols long!";
        }

        if(count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}