<?php
class Viewajax extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method)
	{
		$this->load->model('Viewmodel');
		$data['method'] = $method;
		$data['element'] = $this->Viewmodel->get_element($method);
		$data['title'] = $data['element']->title;
		$data['categories'] = $this->Viewmodel->get_categories();
		$data['comments'] = $this->Viewmodel->get_comments($data['element']->id);
		
		$this->load->view('viewport_ajax', $data);
		$this->load->view('viewscripts', $data);
	}
}
?>