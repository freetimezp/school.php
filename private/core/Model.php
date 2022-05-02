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

    protected function get_primary_key($table) {
        $query = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";

        $db = new Database();
        $data = $db->query($query);

        if(!empty($data[0])) {
            return $data[0]->Column_name;
        }

        return 'id';
    }

    public function where($column, $value, $orderby = 'desc', $limit = 10, $offset = 0) {
        $column = addslashes($column);
        $primary_key = $this->get_primary_key($this->table);

        $query = "SELECT * FROM $this->table WHERE $column = :value ORDER BY $primary_key $orderby LIMIT $limit OFFSET $offset ";
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

    public function first($column, $value, $orderby = 'DESC') {
        $column = addslashes($column);
        $primary_key = $this->get_primary_key($this->table);

        $query = "SELECT * FROM $this->table WHERE $column = :value ORDER BY $primary_key $orderby";
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

    public function findAll($orderby = 'desc', $limit = 10, $offset = 0) {
        $primary_key = $this->get_primary_key($this->table);

        $query = "SELECT * FROM $this->table ORDER BY $primary_key $orderby LIMIT $limit OFFSET $offset";
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
        //remove unwanted columns
        if(property_exists($this, 'allowedColumns')) {
            foreach($data as $key => $column) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        //run function before insert
        if(property_exists($this, 'beforeUpdate')) {
            foreach($this->beforeUpdate as $func) {
                $data = $this->$func($data);
            }
        }

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
