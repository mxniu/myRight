<?php
class Home extends CI_Controller {

	public function index()
	{	
	
		$data['title'] = 'Get Help with Common Legal Issues';
		$data['description'] = 'myRight will help you learn your rights and make sense of the law. Use myRight&apos;s legal guides to learn more about personal issues, criminal penalties, startup and business law, and rights that people are fighting for everyday!';
	
		$this->load->view('home5', $data);
		$this->load->view('commonscripts', $data);
		$this->load->view('layoutfooter', $data);
	}
}
?>