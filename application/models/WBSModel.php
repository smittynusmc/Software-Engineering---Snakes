<?php

Class WBSModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM WBS WHERE WBS_ID = ? ", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function search($data) {
        $WBS_ID = '';
        if (isset($data['WBS_ID'])) {
            $WBS_ID = $data['WBS_ID'];
        }
        $WBS_Name = '';
        if (isset($data['WBS_Name'])) {
            $WBS_Name = $data['WBS_Name'];
        }
       
        $query = "SELECT * "
                . "FROM WBS "
                . "WHERE (? = '' OR WBS_ID =?) "
                . " AND (? = '' OR WBS_Name LIKE CONCAT('%',?,'%') )";
        $inputs = array($WBS_ID, $WBS_ID, $WBS_Name, $WBS_Name);

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }

    public function insert($data) {
        $cleaned = $this->cleanEmpty($data);
        $fields = implode(',', array_keys($cleaned));
        $value = implode(',', array_fill(0, count($cleaned), '?'));
        $query = "INSERT INTO Project ({$fields}) VALUES({$value})";
        if (!$this->db->query($query, $cleaned)) {
            return false;
        } else {
            return true;
        }
    }

    public function update($data) {
        $cleaned = $this->cleanEmpty($data);
        $Project_ID = $cleaned['WBS_ID'];
        unset($cleaned['WBS_ID']);

        $this->db->where('WBS_ID', $Project_ID);
        if (!$this->db->update('WBS', $cleaned)) {
            return false;
        } else {
            return true;
        }
    }

    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array('WBS_ID', 'WBS_Name');
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if(empty($record['WBS_ID']) || empty($record['WBS_ID'])){
                $count_error++;
            }
            elseif (!$this->db->insert('WBS', $record)) {
                $count_error++;
            } else {
                $count_success++;
            }
        }
        $this->db->db_debug = $db_debug;
        return array('error' => $count_error, 'success' => $count_success);
    }

    private function cleanEmpty($data) {
        foreach ($data as $e) {
            if (empty($e)) {
                unset($e);
            }
        }
        return $data;
    }

}
