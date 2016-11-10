<?php

Class OBSModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM view_obs WHERE  obs_id= ?", array($id));
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
		$program_code = '';
        if (isset($data['program_code'])) {
            $program_code = $data['program_code'];
        }
        $program_name = '';
        if (isset($data['program_name'])) {
            $program_name = $data['program_name'];
        }
        $product_code = '';
        if (isset($data['product_code'])) {
            $product_code = $data['product_code'];
        }
        $product_name = '';
        if (isset($data['product_name'])) {
            $product_name = $data['product_name'];
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
                . "FROM view_obs "
                . "WHERE (? = '' OR obs_id =?) "
                . " AND (? = '' OR program_code LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR program_name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR product_code LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR product_name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR wbs_code LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR wbs_name LIKE CONCAT('%',?,'%') )"
                ;
        $inputs = array($obs_id, $obs_id,
            $program_code, $program_code,
            $program_name, $program_name,
            $product_code, $product_code,
            $product_name, $product_name,
            $wbs_code, $wbs_code,
            $wbs_name, $wbs_name
            );

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }
	
	public function insert($data){
		$query = $this->db->get_where('obs',$data);
		if ($query->num_rows() >= 1) {
            return -1;
        } else {
			$query = $this->db->insert('obs',$data);
			$query = $this->db->get_where('obs',$data);
            if ($query->num_rows() >= 1) {
				return $query->result()[0]->obs_id;
			} else {
				return -2;	
			}	
        }
	}
	
	public function update($data){
		$obs_id = $data['obs_id'];
		$query = $this->db->get_where('obs',$data);
		if ($query->num_rows() >= 1) {
            return -1;
        } else {
			$this->db->where('obs_id', $obs_id);
			$this->db->update('obs', $data);
			$query = $this->db->get_where('obs',$data);
            if ($query->num_rows() >= 1) {
				return $query->result()[0]->obs_id;
			} else {
				return -2;	
			}	
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
