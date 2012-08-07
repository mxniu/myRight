<?php
class Functionmodel extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function voterun($action, $id, $votes)
	{
		$my_ip = (string)$_SERVER["REMOTE_ADDR"];
		$sweep_check = $this->db->query('SELECT id FROM votes WHERE lid = '.$id.' AND voter = \''.$my_ip.'\'');
		if($sweep_check->num_rows() > 0)
		{
			echo "FAILED";
			return false;
		}
		
		if($action === 'up')
		{
			$this->db->query('INSERT INTO votes (`voter`,`lid`,`type`) VALUES (\''.$my_ip.'\','.$id.',1)');
			$this->db->query('UPDATE links SET votes = '.((int)$votes + 1).' WHERE id = '.$id);
			echo "SUCCESS";
		}
		else if($action === 'down')
		{
			$this->db->query('INSERT INTO votes (`voter`,`lid`,`type`) VALUES (\''.$my_ip.'\','.$id.',-1)');
			$this->db->query('UPDATE links SET votes = '.((int)$votes - 1).' WHERE id = '.$id);
			echo "SUCCESS";
		}
		else
		{
			echo "FAILED";
			return false;
		}
	}
	
	public function slug_from_tag($tag)
	{
		$this->db->cache_on();
		$query = $this->db->query('SELECT DISTINCT c.slug FROM categories c JOIN links l ON c.id = l.category WHERE l.tags LIKE \'%'.$tag.'%\'');
		if($query->num_rows() <= 0)
			return;
		$row = $query->row();
		$return_cat = $row->slug;
		$query = $this->db->query('SELECT slug FROM tags WHERE tagname = \''.$tag.'\'');
		if($query->num_rows() <= 0)
			return;
		$row = $query->row();
		$return_tag = $row->slug;
		$this->db->cache_off();
		if($return_cat && $return_tag)
			echo 'http://myright.me/'.$return_cat.'/'.$return_tag;
		return;
	}
	
	public function get_test_questions($test_id)
	{
		//$this->db->cache_on();
		$query = $this->db->query('SELECT * FROM questions WHERE test_id = '.$test_id.' ORDER BY seq DESC');
		if($query->num_rows() <= 0)
			return;
		
		$arr = array();
		foreach ($query->result() as $row)
		{
			$arr[] = $row;
		}
		echo json_encode($arr);
		//$this->db->cache_off();
	}
}
?>