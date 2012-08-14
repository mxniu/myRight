<?php
class Layout extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method, $params=array())
	{
		if($method === 'national' || $method === 'startup' || $method === 'tickets'|| $method === 'dui'|| $method === 'drugs'|| $method === 'smallclaims')
		{
			$this->load->model('Commonmodel');
			$this->load->model('Layoutmodel');
			$this->load->helper('form');
			
			$data['locget'] = $this->input->get('location', TRUE);
			$data['offset'] = $this->input->get('page', TRUE);
			$data['debug'] = $this->input->get('debug', TRUE);
			$data['ajax'] = $this->input->get('ajax', TRUE);
			
			//Set offset properly if received
			if($data['offset'] > 0)
				$data['offset']--;
			
			$category_data = $this->Layoutmodel->get_category_data($method);
			$data['method'] = $method;
			$data['urlstem'] = '';
			$data['description'] = 'Learn more about the topic of '.$category_data->name.' at myRight. myRight is a new startup that wants to help everyone learn their rights and know more about the law. Check out the beta release of the site!';
			if(!$data['offset'])
			{
				$data['alltags'] = $this->Commonmodel->get_all_tags();
			}
			if(sizeof($params) == 1)
			{
				$data['urlstem'] = '../';
				if($data['locget'])
					$data['elements'] = $this->Layoutmodel->get_tag_loc_elements($category_data->id, $params[0], $data['locget'], $data['offset']);
				else
					$data['elements'] = $this->Layoutmodel->get_tag_elements($category_data->id, $params[0], $data['offset']);
				if(!$data['offset'])
				{	
					$data['tags'] = $this->Layoutmodel->get_related_tags($category_data->id, $params[0]);
					$data['taginfo'] = $this->Layoutmodel->get_tag_info($params[0]);
					$data['title'] = $data['taginfo']->tagname;
					$data['description'] = 'Learn more about the topic of '.$data['title'].' at myRight. myRight is a new startup that wants to help everyone learn their rights and know more about the law. Check out the beta release of the site!';
			
					if($data['taginfo']->test_id > 0)
					{
						$data['test_id'] = $data['taginfo']->test_id;
					}
					if($data['taginfo']->description !== "")
					{
						$data['top_desc'] = $data['taginfo']->description;
						$data['description'] = $data['taginfo']->description;
					}
					
					//Only include location dropdown for location specific categories
					if($method === 'tickets'|| $method === 'dui'|| $method === 'drugs'|| $method === 'smallclaims')
						$data['locations'] = $this->Layoutmodel->get_tag_locations($category_data->id, $data['taginfo']->id);
				}
				else
				{
					$data['title'] = $method;
				}
			}
			else if(sizeof($params) == 0)
			{
				if($category_data->test_id > 0)
				{
					$data['test_id'] = $category_data->test_id;
				}
				if($category_data->description !== "")
				{
					$data['top_desc'] = $category_data->description;
					$data['description'] = $category_data->description;
				}
				
				if($data['locget'])
					$data['elements'] = $this->Layoutmodel->get_elements_loc($category_data->id, $data['locget'], $data['offset']);
				else
					$data['elements'] = $this->Layoutmodel->get_elements($category_data->id, $data['offset']);
				if(!$data['offset'])
				{	
					$data['title'] = $category_data->name;
					$data['tags'] = $this->Layoutmodel->get_tags($category_data->id);
					
					//Only include location dropdown for location specific categories
					if($method === 'tickets'|| $method === 'dui'|| $method === 'smallclaims')
						$data['locations'] = $this->Layoutmodel->get_locations($category_data->id);
				}
				else
				{
					$data['title'] = $method;
				}
			}
			else
			{
				show_404();
			}
			
			if($data['ajax'] === FALSE)
			{
				$this->load->view('header', $data);
				$this->load->view('layouth2', $data);
			}
			$this->load->view('layoutbody', $data);
			if(!$data['offset'] && $data['ajax'] === FALSE)
			{
				$this->load->view('commonscripts', $data);
			}
			if($data['ajax'] === FALSE)
				$this->load->view('layoutfooter', $data);
			
		}
		else
		{
			show_404();
		}
	}
}
?>