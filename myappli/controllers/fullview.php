<?php
class Fullview extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method)
	{
		$this->load->database();
		$this->load->model('Fullviewmodel');
		$data['element'] = $this->Fullviewmodel->get_element($method);
		$data['method'] = $method;
		
		$this->load->view('fullviewheader', $data);
		$this->load->view('fullviewport', $data);
		$this->load->view('layoutfooter');
	}
}
?>