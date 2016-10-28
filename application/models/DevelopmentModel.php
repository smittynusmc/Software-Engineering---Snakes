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
        $column_names = array("Project_ID","Project_Name","Product_Code","Product_Name","WBS_ID","WBS_Name","Date","SLOC","Hours"
            );
        array_walk($data, function(&$a) use ($column_names) {
            $a = array_combine($column_names, $a);
        });
        $db_debug = $this->db->db_debug;
//        $this->db->db_debug = FALSE;
        foreach ($data as $record) {
            if (!$this->db->insert('View_Development_test', $record)) {
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
