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
	
	public function track_entry()
	{
		$mysqldate = date( 'Y-m-d H:i:s', $this->input->post('time') );	
		
		$ignore_list = array("98.221.128.100", "98.221.129.106", "98.221.144.253", "::1");
		
		if(in_array((string)$_SERVER['REMOTE_ADDR'], $ignore_list))
		{
			return;
		}
		
		if($this->input->post('type') === "ENTRY")
		{
				$this->db->query("INSERT INTO track_entries (type, ip, timestamp) values ('".$this->input->post('type')."','".(string)$_SERVER['REMOTE_ADDR']."', '$mysqldate')");
		}
		else if($this->input->post('type') === "BEGIN" || $this->input->post('type') === "RLOAD" || $this->input->post('type') === "EXIT"  || $this->input->post('type') === "RSKIP" || $this->input->post('type') === "ADCLK" || $this->input->post('type') === "AFCLK")
		{
				$this->db->query("INSERT INTO track_entries (type, ip, test_id, timestamp) values ('".$this->input->post('type')."','".(string)$_SERVER['REMOTE_ADDR']."', ".$this->input->post('test_id').", '$mysqldate')");
		}
		else if($this->input->post('type') === "QLOAD")
		{
				$this->db->query("INSERT INTO track_entries (type, ip, test_id, timestamp, data) values ('".$this->input->post('type')."','".(string)$_SERVER['REMOTE_ADDR']."', ".$this->input->post('test_id').", '$mysqldate', '".$this->input->post('question')."')");
		}
		else
		{
			return;
		}
	}
	
	public function test_name_from_id($test_id)
	{
		$query = $this->db->query("SELECT name FROM categories WHERE test_id = ".$test_id);
        return $query->row();
	}
	
	public function insert_lead($name, $email, $phone, $test_id)
	{
		$my_ip = (string)$_SERVER["REMOTE_ADDR"];
		$mysqldate = date( 'Y-m-d H:i:s', $this->input->post('time') );	
		$this->db->query("INSERT INTO leads (`ip`,`timestamp`,`name`,`email`,`phone`,`test_id`) VALUES ('$my_ip','$mysqldate','$name','$email','$phone',".$test_id.")");
		echo "Thank you! A legal professional will contact you ASAP.";
	}
}
?>