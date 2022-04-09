<?php

class Model extends Database
{
    public $errors = array();

    public function __construct()
    {
        if(!property_exists($this, 'table')) {
            $this->table = strtolower(get_class($this)) . "s";
        }
    }

    public function where($column, $value) {
        $column = addslashes($column);

        $query = "SELECT * FROM $this->table WHERE $column = :value";
        $data = $this->query($query, [
            'value' => $value
        ]);

        //run function after select
        if(is_array($data)) {
            if(property_exists($this,'afterSelect')) {
                foreach($this->afterSelect as $func) {
                    $data = $this->$func($data);
                }
            }
        }

        return $data;

    }

    public function first($column, $value) {
        $column = addslashes($column);

        $query = "SELECT * FROM $this->table WHERE $column = :value";
        $data = $this->query($query, [
            'value' => $value
        ]);

        //run function after select
        if(is_array($data)) {
            if(property_exists($this,'afterSelect')) {
                foreach($this->afterSelect as $func) {
                    $data = $this->$func($data);
                }
            }

            $data = $data[0];
        }

        return $data;

    }

    public function findAll($order = 'desc') {
        $query = "SELECT * FROM $this->table ORDER BY id $order";

        $data = $this->query($query);

        //run function after select
        if(is_array($data)) {
            if(property_exists($this,'afterSelect')) {
                foreach($this->afterSelect as $func) {
                    $data = $this->$func($data);
                }
            }
        }

        return $data;
    }

    public function insert($data) {
        //remove unwanted columns
        if(property_exists($this, 'allowedColumns')) {
            foreach($data as $key => $column) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        //run function before insert
        if(property_exists($this, 'beforeInsert')) {
            foreach($this->beforeInsert as $func) {
                $data = $this->$func($data);
            }
        }

        $keys = array_keys($data);
        $columns = implode(',', $keys);
        $values = implode(',:', $keys);

        $query = "INSERT INTO $this->table ($columns) VALUES (:$values)";
        //echo $query;

        return $this->query($query, $data);
    }

    public function update($id, $data)  {

        $str = "";
        foreach ($data as $key => $value) {
            $str .= $key . "=:" . $key . ",";
        }

        $str = trim($str, ',');
        $data['id'] = $id;

        $query = "UPDATE $this->table SET $str WHERE id = :id";
        return $this->query($query, $data);
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $data['id'] = $id;
        return $this->query($query, $data);
    }
}
