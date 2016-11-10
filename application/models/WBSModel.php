<?php

Class WBSModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM wbs WHERE wbs_id = ? ", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function search($data) {
        $wbs_id = '';
        if (isset($data['wbs_id'])) {
            $wbs_id = $data['wbs_id'];
        }
		$wbs_code = '';
        if (isset($data['wbs_code'])) {
            $wbs_code = $data['wbs_code'];
        }
        $wbs_name = '';
        if (isset($data['wbs_name'])) {
            $wbs_name = $data['wbs_name'];
        }
       
        $query = "SELECT * "
                . "FROM wbs "
                . "WHERE (? = '' OR wbs_id =?) "
                . " AND (? = '' OR wbs_code LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR wbs_name LIKE CONCAT('%',?,'%') )";
        $inputs = array($wbs_id,$wbs_id, $wbs_code,$wbs_code, $wbs_name, $wbs_name);

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }

    public function insert($data) {
        $cleaned = $this->cleanEmpty($data);
        if (!$this->db->insert('wbs', $cleaned)) {
            return false;
        } else {
            
            return $this->db->insert_id();;
        }
    }

    public function update($data) {
        $cleaned = $this->cleanEmpty($data);
        $wbs_id = $cleaned['wbs_id'];
        unset($cleaned['wbs_id']);

        $this->db->where('wbs_id', $wbs_id);
        if (!$this->db->update('wbs', $cleaned)) {
            return false;
        } else {
            return true;
        }
    }

    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array('wbs_code', 'wbs_name');
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if(empty($record['wbs_code']) || empty($record['wbs_code'])){
                $count_error++;
            }
            elseif (!$this->db->insert('wbs', $record)) {
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
