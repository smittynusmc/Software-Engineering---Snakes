<?php

Class OBSModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM VOBS WHERE obs_ID = ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function search($data) {
        $obs_ID = '';
        if (isset($data['obs_ID'])) {
            $obs_ID = $data['obs_ID'];
        }
        $program_ID = '';
        if (isset($data['program_ID'])) {
            $program_ID = $data['program_ID'];
        }
        $product_ID = '';
        if (isset($data['product_ID'])) {
            $product_ID = $data['product_ID'];
        }
        $wbs_ID = '';
        if (isset($data['wbs_ID'])) {
            $wbs_ID = $data['wbs_ID'];
        }
        
        $query = "SELECT * "
                . "FROM obs "
                . "WHERE (? = '' OR obs_ID =?) "
                . " AND (? = '' OR program_ID LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR product_ID =?) "
                . " AND (? = '' OR wbs_ID LIKE CONCAT('%',?,'%') )"
                ;
        $inputs = array($obs_ID, $obs_ID,
            $obs_ID,$obs_ID,
            $program_ID, $program_ID,
            $product_ID, $product_ID,
            $wbs_ID, $wbs_ID,
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
        $column_names = array("obs_ID","program_ID","product_ID","wbs_ID"
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
