<?php 

class ProductModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM product WHERE product_id = ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    public function search($data) {
        $product_id = '';
        if (isset($data['product_id'])) {
            $product_id = $data['product_id'];
        }
		$product_code = '';
        if (isset($data['product_code'])) {
            $product_code = $data['product_code'];
        }
        $product_name = '';
        if (isset($data['product_name'])) {
            $product_name = $data['product_name'];
        }
        $query = "SELECT * "
                . "FROM product "
                . "WHERE (? = '' OR product_id =?) "
                . " AND (? = '' OR product_code LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR product_name LIKE CONCAT('%',?,'%') )";
        $inputs = array($product_id,$product_id, $product_code, $product_code, $product_name, $product_name);

        $result = $this->db->query($query, $inputs);
        if ($result->num_rows() >= 1) {

            return $result->result();
        } else {
            return FALSE;
        }
    }
	
    
    public function insert($data,$overwrite=false,$return_id = false) {
		$cleaned = $this->cleanEmpty($data);
		$query = $this->db->get_where('product', $cleaned);
		if ($query->num_rows() >= 1 ) {
			if(!$overwrite){
				if($return_id){
					return $query->result()[0]->product_id;
				}
				return false;
			}
			$this->db->where('product_id', $query->result()[0]->product_id);
			$this->db->update('product', $cleaned);
			return $query->result()[0]->product_id;
		}
		else{
			$fields = implode(',', array_keys($cleaned));
			$value = implode(',', array_fill(0, count($cleaned), '?'));
			if (!$this->db->insert('product', $cleaned)) {
				return false;
			} else {
				
				return $this->db->insert_id();
			}
		}		
        
    }
    
    public function update($data) {
        $cleaned = $this->cleanEmpty($data);
        $product_code = $cleaned['product_code'];
        unset($cleaned['product_code']);

        $this->db->where('product_code', $product_code);
        if (!$this->db->update('product', $cleaned)) {
            return false;
        } else {
            return true;
        }
    }
    
    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array('product_code', 'product_name');
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if(empty($record['product_code']) || empty($record['product_name'])){
                $count_error++;
            }
            elseif (!$this->db->insert('product', $record)) {
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
