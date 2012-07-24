<?php
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->model('Viewmodel');
		$data['categories'] = $this->Viewmodel->get_categories();
		$data['title'] = "Login";
	
		$this->load->view('header', $data);
		$this->load->view('loginview');
	}
}
?>