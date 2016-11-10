<?php

Class ProgramModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM program WHERE program_id = ? ", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function search($data) {
        $program_id = '';
        if (isset($data['program_id'])) {
            $program_id = $data['program_id'];
        }
        $program_code = '';
        if (isset($data['program_code'])) {
            $program_code = $data['program_code'];
        }
        $program_name = '';
        if (isset($data['program_name'])) {
            $program_name = $data['program_name'];
        }
        $build_date = '1900-01-01';
        if (isset($data['build_date']) && !empty($data['build_date'])) {
            $build_date = $data['build_date'];
        }
        $end_date = '2900-12-31';
        if (isset($data['end_date']) && !empty($data['end_date'])) {
            $end_date = $data['end_date'];
        }
        $query = "SELECT * "
                . "FROM program "
                . "WHERE (? = '' OR program_id =?) "
                . " AND (? = '' OR program_code LIKE concat('%',?,'%') )"
                . " AND (? = '' OR program_name LIKE concat('%',?,'%') )"
                . " and (build_date >= ? and end_date <= ? )";
        $inputs = array($program_id, $program_id, $program_code, $program_code,$program_name, $program_name, $build_date, $end_date);

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
        if (!$this->db->insert('program', $cleaned)) {
            return false;
        } else {
            
            return $this->db->insert_id();;
        }
    }

    public function update($data) {
        $cleaned = $this->cleanEmpty($data);
        $program_id = $cleaned['program_id'];
        unset($cleaned['program_id']);

        $this->db->where('program_id', $program_id);
        if (!$this->db->update('program', $cleaned)) {
            return false;
        } else {
            return true;
        }
    }

    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array( 'program_code','program_name', 'build_date', 'end_date');
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if(empty($record['program_code']) || empty($record['program_name'])){
                $count_error++;
            }
            elseif (!$this->db->insert('program', $record)) {
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
