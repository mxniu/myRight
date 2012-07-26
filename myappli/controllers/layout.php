<?php
class Layout extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method, $params=array())
	{
		if($method === 'election2012' || $method === 'startups'|| $method === 'tickets'|| $method === 'dui'|| $method === 'drugs'|| $method === 'smallclaims')
		{
			$this->load->model('Layoutmodel');
			$category_data = $this->Layoutmodel->get_category_data($method);
			$data['title'] = $category_data->name;
			$data['method'] = $method;
			$data['urlstem'] = '';
			$data['categories'] = $this->Layoutmodel->get_categories();
			if(sizeof($params) == 1)
			{
				$data['urlstem'] = '../';
				$data['elements'] = $this->Layoutmodel->get_tag_elements($category_data->id, $params[0]);
				$data['tags'] = $this->Layoutmodel->get_related_tags($category_data->id, $params[0]);
			}
			else if(sizeof($params) == 0)
			{
				$data['elements'] = $this->Layoutmodel->get_elements($category_data->id);
				$data['tags'] = $this->Layoutmodel->get_tags($category_data->id);
			}
			else
			{
				show_404();
			}
			
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