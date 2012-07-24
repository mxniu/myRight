<?php
class Wah extends CI_Controller {

	public function index()
	{
		$this->load->model('wahmodel');
		$this->load->helper('url');
		$this->load->view('wahview');
	}
}
?>