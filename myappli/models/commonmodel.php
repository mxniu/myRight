<?php
class Commonmodel extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function get_all_tags()
	{
		$this->db->cache_on();
		$query = $this->db->query('SELECT tagname FROM tags');
		$this->db->cache_off();
		return $query->result();
	}
}
?>