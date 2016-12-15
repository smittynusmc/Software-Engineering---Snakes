<?php

Class DevelopmentModel extends CI_Model {
	private $log_path = "logs/applog.txt";
	private function debuglog($mess,$data=null){
		write_file($this->log_path,"\n".$mess.":\n".print_r($data,true),'a');
	}
    public function get($id) {
        $result = $this->db->query("SELECT * FROM view_development WHERE development_id = ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function search($data) {
        $development_id = '';
        if (isset($data['development_id'])) {
            $development_id = $data['development_id'];
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
       
        $wbs_name = '';
        if (isset($data['wbs_name'])) {
            $wbs_name = $data['wbs_name'];
        }
        $sloc = '';
        if (isset($data['sloc'])) {
            $sloc = $data['sloc'];
        }
		if (isset($data['hours'])) {
            $hours = $data['hours'];
        }
        $query = "SELECT * "
                . "FROM view_development "
                . "WHERE (? = '' OR development_id =?) "
                . " AND (? = '' OR program_name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR product_name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR wbs_name LIKE CONCAT('%',?,'%') ) "
                . " AND (? = '' OR sloc = ?) "
                . " AND (? = '' OR hours= ?) "
                ;
        $inputs = array($development_id, $development_id,
            $program_name, $program_name,
            $product_name, $product_name,
            $wbs_name, $wbs_name,
            $sloc, $sloc,
            $hours, $hours
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
      
        $db_debug = $this->db->db_debug;
//        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            try{
                $this->insert_development($record);
                $count_success++;
            } catch (Exception $ex) {
                $count_error++;
            }
                
        }
        $this->db->db_debug = $db_debug;
        return array('error' => $count_error, 'success' => $count_success);
    }
    
	
	
	public function update($data) {
        $cleaned = $this->cleanEmpty($data);
        $development_id = $cleaned['development_id'];
        unset($cleaned['development_id']);

        $this->db->where('development_id', $development_id);
        if (!$this->db->update('development', $cleaned)) {
            return false;
        } else {
            return true;
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
	
    public function insert($data,$overwrite=false) {
        $cleaned = $this->cleanEmpty($data);
        $query = $this->db->get_where('development', $cleaned);
		if ($query->num_rows() >= 1 ) {
			if(!$overwrite){
				return false;
			}
			$this->db->where('development_id', $query->result()[0]->development_id);
			$this->db->update('development', $cleaned);
			return $query->result()[0]->development_id;
		}
		else{
			$fields = implode(',', array_keys($cleaned));
			$value = implode(',', array_fill(0, count($cleaned), '?'));
			if (!$this->db->insert('development', $cleaned)) {
				return false;
			} else {
				
				return $this->db->insert_id();
			}
		}	
    }   
	public function development_cost_report($data){
		
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
		
		$program_detail_level= $data['program_detail_level'];
		$product_detail_level= $data['product_detail_level'];
		$wbs_detail_level= $data['wbs_detail_level'];
		if($program_detail_level ==1
			&& $product_detail_level == 1
			&& $wbs_detail_level == 1){
				$group_by_field = "program_id,program_name,product_id,product_name,wbs_id,wbs_name";
			}
		elseif($program_detail_level ==1
			&& $product_detail_level == 1){
				$group_by_field = "program_id,program_name,product_id,product_name";
			}
		elseif($program_detail_level ==1){
			$group_by_field = "program_id,program_name";
		}
		else{
			return FALSE;
		}
		
		$query = "SELECT * FROM(
				SELECT $group_by_field,SUM(sloc) sum_sloc,SUM(hours) sum_hours,AVG(sloc) avg_sloc,avg(hours) avg_hours
				FROM view_development
				WHERE (program_id = ? OR 0 = ?)
					AND (product_id = ? OR 0 = ?)
					AND (wbs_id = ? OR 0 = ?)
				GROUP BY $group_by_field
				) pull
				ORDER BY $group_by_field
				";
				
		$inputs = array($program_id, $program_id,
            $product_id, $product_id,
            $wbs_id, $wbs_id,
		);
        $result = $this->db->query($query, $inputs);
		if ($result->num_rows() >= 0) {

            return $result->result_array();
        } else {
            return FALSE;
        }	
	}
}
