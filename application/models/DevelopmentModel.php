<?php

Class DevelopmentModel extends CI_Model {

    public function get($id) {
        $result = $this->db->query("SELECT * FROM View_Development WHERE Development_ID = ?", array($id));
        if ($result->num_rows() >= 1) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function search($data) {
        $Project_ID = '';
        if (isset($data['Project_ID'])) {
            $Project_ID = $data['Project_ID'];
        }
        $Project_Name = '';
        if (isset($data['Project_Name'])) {
            $Project_Name = $data['Project_Name'];
        }
        $Product_Code = '';
        if (isset($data['Product_Code'])) {
            $Product_Code = $data['Product_Code'];
        }
        $Product_Name = '';
        if (isset($data['Product_Name'])) {
            $Product_Name = $data['Product_Name'];
        }
        $WBS_ID = '';
        if (isset($data['WBS_ID'])) {
            $WBS_ID = $data['WBS_ID'];
        }
        $WBS_Name = '';
        if (isset($data['WBS_Name'])) {
            $WBS_Name = $data['WBS_Name'];
        }
        
        $query = "SELECT * "
                . "FROM View_Development "
                . "WHERE (? = '' OR Project_ID =?) "
                . " AND (? = '' OR Project_Name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR Product_Code =?) "
                . " AND (? = '' OR Product_Name LIKE CONCAT('%',?,'%') )"
                . " AND (? = '' OR WBS_ID =?) "
                . " AND (? = '' OR WBS_Name LIKE CONCAT('%',?,'%') )"
                ;
        $inputs = array($Project_ID, $Project_ID,
            $Project_Name, $Project_Name,
            $Product_Code, $Product_Code,
            $Product_Name, $Product_Name,
            $WBS_ID, $WBS_ID,
            $WBS_Name, $WBS_Name,
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
        $column_names = array("Project_ID","Product_Code","WBS_ID","WBS_Name","Date","SLOC","Hours"
            );
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
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
    
    private function insert_development($record){
        $wbs_project_product_qry = "
            SELECT Project_ProductID,WBS_Project_Product_ID
            FROM Project_Product
            LEFT JOIN WBS_Project_Product USING(Project_ProductID)
            WHERE Project_ID = ? 
                AND Product_Code = ? 
                AND (WBS_ID = ? 
                    OR WBS_Project_Product_ID IS NULL)";
        $inputs = array($record['Project_ID'], $record['Product_Code'], $record['WBS_ID']);
        $wbs_project_product = $this->db->query($wbs_project_product_qry, $inputs);
        if($wbs_project_product->num_rows() == 1){
            $wpp = $wbs_project_product->result();
            if(empty($wpp[0]->Wbs_Project_Product_ID)){
                $this->db->insert('WBS_Project_Product',array('Project_ProductID'=>$wpp[0]->Project_ProductID
                        ,'WBS_ID'=>$record['WBS_ID']));
            }            
        }
        else{
            $this->db->insert('Project_Product',array('Project_ID'=>$record['Project_ID']
                        ,'Product_code'=>$record['Product_Code']));
            $wbs_project_product_insert = "INSERT INTO WBS_Project_Product (Project_ProductID,WBS_ID)
                    SELECT Project_ProductID, ?
                    FROM Project_Product
                    WHERE Project_ID = ? AND Product_Code = ?" ;     
            $this->db->query($wbs_project_product_qry, array($record['WBS_ID'],$record['Project_ID'], $record['Product_Code'] ));
            
        }
        
        $development_insert = "
            INSERT INTO Development (WBS_Project_Product_ID,Date,SLOC,Hours)
            SELECT WBS_Project_Product_ID,?,?,?
            FROM Project_Product 
            LEFT JOIN WBS_Project_Product USING(Project_ProductID)
            WHERE Project_ID = ? AND Product_Code = ? AND WBS_ID = ? ";
        $this->db->query($development_insert, array($record['Date'],$record['SLOC'],$record['Hours']
            ,$record['Project_ID'], $record['Product_Code'],$record['WBS_ID'] ));
                
    }

    
}
