<?php

Class CPCRModel extends CI_Model {
	private $log_path = "logs/applog.txt";
    public function get($id) {
        $result = $this->db->query("SELECT * FROM view_cpcr WHERE  cpcr_id= ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }
	private function debuglog($mess,$data=null){
		write_file($this->log_path,"\n".$mess.":\n".print_r($data,true),'a');
	}
    public function search($data) {
        $cpcr_id = '';
        if (isset($data['cpcr_id'])) {
            $cpcr_id = $data['cpcr_id'];
        }
        $program_name = '';
        if (isset($data['program_name'])) {
            $program_name = $data['program_name'];
        }
        $product_name = '';
        if (isset($data['product_name'])) {
            $product_name = $data['product_name'];
        }
		$wbs_name = '';
        if (isset($data['wbs_name'])) {
            $wbs_name = $data['wbs_name'];
        }
		$cpcr_status = '';
        if (isset($data['cpcr_status'])) {
            $cpcr_status = $data['cpcr_status'];
        }
		$updated = '1900-01-01';
        if (isset($data['updated']) && !empty($data['updated'])) {
            $updated = $data['updated'];
        }
        $created = '2900-12-31';
        if (isset($data['created']) && !empty($data['created'])) {
            $created = $data['created'];
        }
        
        $query = "SELECT * "
                . "FROM view_cpcr "
                . "WHERE (? = '' OR cpcr_id =?) "
                . " AND (? = '' OR program_name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR product_name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR wbs_name LIKE CONCAT('%',?,'%') )"
				. " AND (? = '' OR cpcr_status LIKE CONCAT('%',?,'%') )"
				. " AND (updated >= ? OR updated <= ? )"
				. " AND (created >= ? OR created <= ? )"
                ;
        $inputs = array($cpcr_id, $cpcr_id,
            $program_name, $program_name,
            $product_name, $product_name,
            $wbs_name, $wbs_name,
			$cpcr_status, $cpcr_status,
			$updated, $updated,
			$created, $created
            );

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }
	
	public function insert($data){
		if (!$this->db->insert('cpcr', $data)) {
            return false;
        } else {
            
            return $this->db->insert_id();;
        }
		
	}
	
	public function update($data){	
		
		$cleaned = $this->cleanEmpty($data);
        $cpcr_id = $cleaned['cpcr_id'];
        unset($cleaned['cpcr_id']);

        $this->db->where('cpcr_id', $cpcr_id);
        if (!$this->db->update('cpcr', $cleaned)) {
            return false;
        } else {
            return true;
        }
	}
	
	public function get_status_codeset(){
		$query = $this->db->get_where('cpcr_status',array('active'=>1));
		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;	
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
	
	public function cpcr_status_report($data){
		
        $program_id = 0;
        if (!empty($data['program_id'])) {
            $program_id = $data['program_id'];
        }
        $product_id = 0;
        if (!empty($data['product_id'])) {
            $product_id = $data['product_id'];
        }
		$wbs_id = 0;
        if (!empty($data['wbs_id'])) {
            $wbs_id = $data['wbs_id'];
        }
		$cpcr_status = 'ALL';
        if (!empty($data['cpcr_status'])) {
            $cpcr_status = $data['cpcr_status'];
        }
		
		$query = "SELECT  program_id,program_name,product_id,product_name,wbs_id,wbs_name,cpcr_status
				FROM view_cpcr
				WHERE (program_id = ? OR 0 = ?)
					AND (product_id = ? OR 0 = ?)
					AND (wbs_id = ? OR 0 = ?)
					AND (cpcr_status = ? OR 'ALL' = ?)
				ORDER BY program_name,product_name,wbs_name,cpcr_status
				";
		$inputs = array($program_id, $program_id,
            $product_id, $product_id,
            $wbs_id, $wbs_id,
			$cpcr_status, $cpcr_status
            );
        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 0) {

            return $result->result();
        } else {
            return FALSE;
        }		
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
