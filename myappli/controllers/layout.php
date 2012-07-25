<?php
class Layout extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method)
	{
		if($method === 'election2012' || $method === 'startups'|| $method === 'tickets'|| $method === 'dui'|| $method === 'drugs'|| $method === 'smallclaims')
		{
			$this->load->model('Layoutmodel');
			$category_data = $this->Layoutmodel->get_category_data($method);
			$data['title'] = $category_data->name;
			$data['method'] = $method;
			$data['categories'] = $this->Layoutmodel->get_categories();
			$data['elements'] = $this->Layoutmodel->get_elements($category_data->id);

			$this->load->view('header', $data);
			$this->load->view('layouth2', $data);
			$this->load->view('layoutbody', $data);
			$this->load->view('layoutfooter', $data);
		}
		else
		{
			show_404();
		}
	}
}
?>