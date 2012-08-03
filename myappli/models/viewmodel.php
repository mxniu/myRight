<?php
class Viewmodel extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function get_element($slug)
	{
		$this->db->select('*');
		$this->db->where('slug', $slug);
	
		$query = $this->db->get('links');
        return $query->row();
	}
	
	public function get_categories()
	{
		$this->db->select('name, slug');
	
		$query = $this->db->get('categories');
        return $query->result();
	}
	
	public function get_comments($element_id)
	{
		$this->db->select('*');
		$this->db->where('element_id', $element_id);
		
		$query = $this->db->get('comments');
		return $query->result();
	}
	
	public function get_category_data($id)
	{
		$this->db->cache_on();
		$this->db->select('slug');
		$this->db->where('id', $id);
	
		$query = $this->db->get('categories');
		$temp = $query->row();
		$this->db->cache_off();
		
        return $temp;
	}
}
?>