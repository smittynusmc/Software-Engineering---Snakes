<?php
Class CommonModel extends CI_Model {
	public function getTable($table){
		$query = $this->db->get($table);
		return $query->result();
	}
}
?>