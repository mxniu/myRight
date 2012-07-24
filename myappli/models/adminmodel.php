<?php
class Adminmodel extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function get_element($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
	
		$query = $this->db->get('links');
        return $query->row();
	}
	
	public function get_elements($category)
	{
		$this->db->select('id, title, votes');
		$this->db->where('category', $category);
		$this->db->order_by('votes desc');
	
		$query = $this->db->get('links');
        $categories_array = array();
		foreach ($query->result() as $row)
		{
			$categories_array[$row->id] = '['.$row->votes.']'.$row->title; 
		}
		return $categories_array;
	}

	public function create_element()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
		
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'summary' => $this->input->post('summary'),
			'url' => $this->input->post('url'),
			'category' => $this->input->post('category'),
			'tags' => $this->input->post('tags'),
			'votes' => $this->input->post('votes'),
			'type' => $this->input->post('type')
		);
		
		return $this->db->insert('links', $data);
	}
	
	public function edit_element()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
		
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'summary' => $this->input->post('summary'),
			'url' => $this->input->post('url'),
			'category' => $this->input->post('category'),
			'tags' => $this->input->post('tags'),
			'votes' => $this->input->post('votes'),
			'type' => $this->input->post('type')
		);
		
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('links', $data);
	}
	
	public function delete_element()
	{
		$this->db->where('id', $this->input->post('id'));
		return $this->db->delete('links');
	}
	
	private function slug_script()
	{
		$this->load->helper('url');
	
		$this->db->select('id, title');
	
		$query = $this->db->get('links');
        foreach ($query->result() as $row)
		{
			$slug = url_title($row->title, 'dash', TRUE);
			$id = $row->id;
			$data = array(
               'slug' => $slug
            );

			$this->db->where('id', $id);
			$this->db->update('links', $data); 
		}
	}
	
	public function get_categories()
	{
		$this->db->select('id, name');
	
		$query = $this->db->get('categories');
		$categories_array = array();
		foreach ($query->result() as $row)
		{
			$categories_array[$row->id] = $row->name; 
		}
		
        return $categories_array;
	}
}
?>