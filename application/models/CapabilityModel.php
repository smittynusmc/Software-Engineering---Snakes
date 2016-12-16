<?php 

class CapabilityModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM capability WHERE capability_id = ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    public function search($data) {
        $capability_id = '';
        if (isset($data['capability_id'])) {
            $capability_id = $data['capability_id'];
        }
        $capability_name = '';
        if (isset($data['capability_name'])) {
            $capability_name = $data['capability_name'];
        }
        $query = "SELECT * "
                . "FROM capability "
                . "WHERE (? = '' OR capability_id =?) "
                . " AND (? = '' OR capability_name LIKE CONCAT('%',?,'%') )";
        $inputs = array($capability_id,$capability_id,$capability_name, $capability_name);

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }
    
	
	
	public function insert($data,$overwrite = false,$return_id = false) {
        $cleaned = $this->cleanEmpty($data);
		$query = $this->db->get_where('capability',$cleaned);
		if ($query->num_rows() >= 1 ) {
			if(!$overwrite){
				if($return_id){
					return $query->result()[0]->capability_id;
				}
				return false;
			}
			$this->db->where('capability_id', $query->result()[0]->capability_id);
			$this->db->update('capability', $cleaned);
			return $query->result()[0]->capability_id;
		}
		else{
			$fields = implode(',', array_keys($cleaned));
			$value = implode(',', array_fill(0, count($cleaned), '?'));
			if (!$this->db->insert('capability', $cleaned)) {
				return false;
			} else {
				
				return $this->db->insert_id();
			}
		}		
    }
    
    public function update($data) {
        $cleaned = $this->cleanEmpty($data);
		$capability_id = $cleaned['capability_id'];
        unset($cleaned['capability_id']);

        $this->db->where('capability_id', $capability_id);
        if (!$this->db->update('capability', $cleaned)) {
            return false;	
        } else {
            return true;
        }
    }
    
    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array('capability_name');
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if(empty($record['capability_name'])){
                $count_error++;
            }
            elseif (!$this->db->insert('capability', $record)) {
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
