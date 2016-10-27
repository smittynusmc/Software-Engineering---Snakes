<?php
Class ProjectModel extends CI_Model {
    public function get($id){
        $result = $this->db->query("SELECT * FROM Project WHERE Project_ID = ?",array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function search($data){
        $Project_ID = '';
        if(isset($data['Project_ID'])){
            $Project_ID = $data['Project_ID'];
        }
        $Project_Name = '';
        if(isset($data['Project_Name']) ){
            $Project_Name = $data['Project_Name'];
        }
        $Build_Date = '1900-01-01';
        if(isset($data['Build_Date']) && !empty($data['Build_Date'])){
            $Build_Date = $data['Build_Date'];
        }
        $End_Date = '2900-12-31';
        if(isset($data['End_Date'])&& !empty($data['End_Date'])){
            $End_Date = $data['End_Date'];
        }
        $query = "SELECT * "
                . "FROM Project "
                . "WHERE (? = '' OR Project_ID =?) "
                . " AND (? = '' OR Project_Name LIKE CONCAT('%',?,'%') )"
                . " AND (Build_Date >= ? AND End_Date <= ? )";
        $inputs = array($Project_ID,$Project_ID,$Project_Name,$Project_Name,$Build_Date,$End_Date);
        
        $result =  $this->db->query($query,$inputs);
        if ($result->num_rows() >= 1) {
            
            return $result->result();
        } else {
            return FALSE  ;
        }
    }
    
    public function insert($data){
        $cleaned = $this->cleanEmpty($data);
        $fields = implode(',',array_keys($cleaned));
        $value = implode(',', array_fill(0, count($cleaned), '?'));
        $query = "INSERT INTO Project ({$fields}) VALUES({$value})";
        if(!$this->db->query($query,$cleaned)){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function update($data){
        $cleaned = $this->cleanEmpty($data);
        $Project_ID = $cleaned['Project_ID'];
        unset($cleaned['Project_ID']);
        
        $this->db->where('Project_ID', $Project_ID);        
        if(!$this->db->update('Project', $cleaned)){
            return false;
        }
        else{
            return true;
        }
    }
    
    private function cleanEmpty($data){
        foreach($data as $e){
            if(empty($e)){
                unset($e);
            }
        }
        return $data;
    }
    
}
