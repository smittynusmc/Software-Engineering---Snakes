<?php 

class SprintModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM sprint WHERE sprint_ID = ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    public function search($data) {
        $sprint_id = '';
        if (isset($data['sprint_id'])) {
            $sprint_id = $data['sprint_id'];
        }
        $sprint_name = '';
        if (isset($data['sprint_name'])) {
            $sprint_name = $data['sprint_name'];
        }
        $query = "SELECT * "
                . "FROM sprint "
                . "WHERE (? = '' OR sprint_id =?) "
                . " AND (? = '' OR sprint_name LIKE CONCAT('%',?,'%') )";
        $inputs = array($sprint_id, $sprint_id, $sprint_name, $sprint_name);

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }
    
 
	public function insert($data,$overwrite=false,$return_id = false) {
		$cleaned = $this->cleanEmpty($data);
		$query = $this->db->get_where('sprint',  array('sprint_name'=>trim($cleaned['sprint_name'])));
		if ($query->num_rows() >= 1 ) {
			if(!$overwrite){
				if($return_id){
					return $query->result()[0]->sprint_id;
				}
				return false;
			}
			$this->db->where('sprint_id', $query->result()[0]->sprint_id);
			$this->db->update('sprint', $cleaned);
			return $query->result()[0]->sprint_id;
		}
		else{
			$fields = implode(',', array_keys($cleaned));
			$value = implode(',', array_fill(0, count($cleaned), '?'));
			if (!$this->db->insert('sprint', $cleaned)) {
				return false;
			} else {
				
				return $this->db->insert_id();
			}
		}		
        
    }
    
    public function update($data) {
        $cleaned = $this->cleanEmpty($data);
        $sprint_id = $cleaned['sprint_id'];
        unset($cleaned['sprint_id']);

        $this->db->where('sprint_id', $sprint_id);
        if (!$this->db->update('sprint', $cleaned)) {
            return false;
        } else {
            return true;
        }
    }
    
    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array('sprint_id', 'sprint_Name');
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if(empty($record['sprint_id']) || empty($record['sprint_Name'])){
                $count_error++;
            }
            elseif (!$this->db->insert('sprint', $record)) {
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
