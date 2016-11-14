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
        $Product_Name = '';
        if (isset($data['Product_Name'])) {
            $Product_Name = $data['Product_Name'];
        }
        $query = "SELECT * "
                . "FROM Product "
                . "WHERE (? = '' OR Product_Code =?) "
                . " AND (? = '' OR Product_Name LIKE CONCAT('%',?,'%') )";
        $inputs = array($Product_Code, $Product_Code, $Product_Name, $Product_Name);

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
        $query = "INSERT INTO Product ({$fields}) VALUES({$value})";
        if (!$this->db->query($query, $cleaned)) {
            return false;
        } else {
            return true;
        }
    }
    
    public function update($data) {
        $cleaned = $this->cleanEmpty($data);
        $Product_Code = $cleaned['Product_Code'];
        unset($cleaned['Product_Code']);

        $this->db->where('Product_Code', $Product_Code);
        if (!$this->db->update('Product', $cleaned)) {
            return false;
        } else {
            return true;
        }
    }
    
    public function import($data) {
        $count_error = 0;
        $count_success = 0;
        $column_names = array('Product_Code', 'Product_Name');
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if(empty($record['Product_Code']) || empty($record['Product_Name'])){
                $count_error++;
            }
            elseif (!$this->db->insert('Product', $record)) {
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
