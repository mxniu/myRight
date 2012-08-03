<?php
class Viewscreen extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method)
	{
		$this->load->model('Commonmodel');
		$this->load->model('Viewmodel');
		$data['method'] = $method;
		$data['element'] = $this->Viewmodel->get_element($method);
		$data['title'] = $data['element']->title;
		$data['comments'] = $this->Viewmodel->get_comments($data['element']->id);
		$data['description'] = $data['element']->summary;
		$data['alltags'] = $this->Commonmodel->get_all_tags();
		//$data['category'] = $this->Viewmodel->get_category_data($data['element']->id);
		
		$this->load->view('header', $data);
		$this->load->view('viewport', $data);
		$this->load->view('viewscripts', $data);
		$this->load->view('commonscripts', $data);
		$this->load->view('layoutfooter');
	}
}
?>