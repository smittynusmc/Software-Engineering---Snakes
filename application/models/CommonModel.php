<?php
Class CommonModel extends CI_Model {
	public function getTable($table){
		$query = $this->db->get($table);
		return $query->result();
	}
	public function getOBSList(){
		
		$this->db->from('view_obs');
		$this->db->order_by("program_id", "asc");
		$this->db->order_by("product_id", "asc");
		$this->db->order_by("wbs_id", "asc");
		$query = $this->db->get();
		return $query->result();
	}
}
?>