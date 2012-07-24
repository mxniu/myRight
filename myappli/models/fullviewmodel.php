<?php
class Fullviewmodel extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function get_element($slug)
	{
		$this->db->select('id, title, url');
		$this->db->where('slug', $slug);
	
		$query = $this->db->get('links');
        return $query->row();
	}
}
?>