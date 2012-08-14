<?php
class Functioning extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function vote()
	{
		$this->load->model('Functionmodel');
		$this_action = $this->input->post('action');
		$this_id = $this->input->post('id');
		$this_votes = $this->input->post('votes');
		
		return $this->Functionmodel->voterun($this_action, $this_id, $this_votes);
	}
	
	public function find_slug()
	{
		$this->load->model('Functionmodel');
		$tag = $this->input->post('tag');
		
		return $this->Functionmodel->slug_from_tag($tag);
	}
	
	public function show_terms()
	{
		$this->load->view('termsofuse');
	}
	
	public function show_disclaimer() 
	{
		$this->load->view('disclaimer'); 
	}
	
	public function show_privacy() 
	{
		$this->load->view('privacy'); 
	}
	
	public function get_issue()
	{
		$this->load->model('Functionmodel');
		$test_id = $this->input->post('test_id');
		
		return $this->Functionmodel->get_test_questions($test_id);
	}
	
	public function reorg_list()
	{
		$this->load->model('Layoutmodel');
		$this_category = $this->input->post('category');
		$this_tag = $this->input->post('tagname');
		$this_location = $this->input->post('location');
		
		$this->Layoutmodel->get_tag_elements($this_category, $this_tag);
	}
}
?>