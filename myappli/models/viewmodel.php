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
	
	public function add_view($id, $views)
	{
		$my_ip = (string)$_SERVER["REMOTE_ADDR"];
		/*$sweep_check = $this->db->query('SELECT id FROM votes WHERE lid = '.$id.' AND voter = \''.$my_ip.'\'');
		if($sweep_check->num_rows() > 0)
		{
			return false;
		}*/
		
		$this->db->query('INSERT INTO views (`viewer`,`lid`) VALUES (\''.$my_ip.'\','.$id.')');
		$this->db->query('UPDATE links SET views = '.((int)$views + 1).' WHERE id = '.$id);
	}
}
?>