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
		if($data['element']->poster != "0")
		{
			$data['poster'] = $this->Viewmodel->get_poster($data['element']->poster);
		}
		else
			$data['poster'] = 0;
		$data['title'] = $data['element']->title;
		$data['comments'] = $this->Viewmodel->get_comments($data['element']->id);
		
		$this->Viewmodel->add_view($data['element']->id, $data['element']->views);
		
		$this->load->view('viewport_ajax', $data);
		$this->load->view('viewscripts', $data);
	}
}
?>