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
}
?>