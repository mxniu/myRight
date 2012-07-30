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
			$this->load->helper('form');
			$category_data = $this->Layoutmodel->get_category_data($method);
			$data['method'] = $method;
			$data['urlstem'] = '';
			$data['categories'] = $this->Layoutmodel->get_categories();
			$data['locget'] = $this->input->get('location', TRUE);
			$data['offset'] = $this->input->get('page', TRUE);
			$data['alltags'] = $this->Layoutmodel->get_all_tags();
			if(sizeof($params) == 1)
			{
				$data['urlstem'] = '../';
				if($data['locget'])
					$data['elements'] = $this->Layoutmodel->get_tag_loc_elements($category_data->id, $params[0], $data['locget'], $data['offset']);
				else
					$data['elements'] = $this->Layoutmodel->get_tag_elements($category_data->id, $params[0], $data['offset']);
				$data['tags'] = $this->Layoutmodel->get_related_tags($category_data->id, $params[0]);
				$data['taginfo'] = $this->Layoutmodel->get_tag_info($params[0]);
				$data['title'] = $data['taginfo']->tagname;
				$data['locations'] = $this->Layoutmodel->get_tag_locations($category_data->id, $data['taginfo']->id);
			}
			else if(sizeof($params) == 0)
			{
				$data['title'] = $category_data->name;
				if($data['locget'])
					$data['elements'] = $this->Layoutmodel->get_elements_loc($category_data->id, $data['locget'], $data['offset']);
				else
					$data['elements'] = $this->Layoutmodel->get_elements($category_data->id, $data['offset']);
				$data['tags'] = $this->Layoutmodel->get_tags($category_data->id);
				$data['locations'] = $this->Layoutmodel->get_locations($category_data->id);
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