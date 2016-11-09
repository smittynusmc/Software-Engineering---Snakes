<?php

Class OBSModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM obs WHERE obs_id = ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function search($data) {
        $obs_id = '';
        if (isset($data['obs_id'])) {
            $obs_id = $data['obs_id'];
        }
        $program_id = '';
        if (isset($data['program_id'])) {
            $program_id = $data['program_id'];
        }
        $product_id = '';
        if (isset($data['product_id'])) {
            $product_id = $data['product_id'];
        }
        $wbs_id = '';
        if (isset($data['wbs_id'])) {
            $wbs_id = $data['wbs_id'];
        }
        
        $query = "SELECT * "
                . "FROM obs "
                . "WHERE (? = '' OR obs_id =?) "
                . " AND (? = '' OR program_id LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR product_id =?) "
                . " AND (? = '' OR wbs_id LIKE CONCAT('%',?,'%') )"
                ;
        $inputs = array($obs_id, $obs_id,
            $program_id, $program_id,
            $product_id, $product_id,
            $wbs_id, $wbs_id,
            );

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }


    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array("obs_id","program_id","product_id","wbs_id"
            );
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
//        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            try{
                $this->insert_obs($record);
                $count_success++;
            } catch (Exception $ex) {
                $count_error++;
            }
                
        }
        $this->db->db_debug = $db_debug;
        return array('error' => $count_error, 'success' => $count_success);
    }

    
}
