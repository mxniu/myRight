<?php
class Home extends CI_Controller {

	public function index()
	{	
		$this->load->model('Commonmodel');
	
		$data['title'] = 'Bringing the Law back to the People';
		$data['description'] = 'myRight is a new startup that wants to help everyone learn their rights and know more about the law. Check out the beta release of the site!';
		$data['alltags'] = $this->Commonmodel->get_all_tags();
	
		$this->load->view('header', $data);
		$this->load->view('commonscripts', $data);
		$this->load->view('home', $data);
		$this->load->view('layoutfooter', $data);
	}
}
?>