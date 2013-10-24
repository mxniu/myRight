<?php
class Layout extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method, $params=array())
	{
		if($method === 'lawstudents')
		{
			$data['title'] = 'For Law Students';
			$data['description'] = 'If you are a law student and you care about contributing to a free, open database of legal knowledge, join the myRight Law Review today. Imagine a world in which every single person on the planet is given free access to the sum of all basic legal knowledge.';
		
			$this->load->view('header4', $data);
			$this->load->view('lawstudents');
			$this->load->view('commonscripts');
			$this->load->view('layoutfooter');
		}
		else
		{
			$this->load->model('Commonmodel');
			$this->load->model('Layoutmodel2');
			$categories = $this->Layoutmodel2->get_categories();
	
			if(in_array($method, $categories))
			{
				$this->load->helper('form');
				
				$data['locget'] = $this->input->get('location', TRUE);
				$data['debug_mode'] = '';
				if($this->input->get('debug', TRUE))
					$data['debug_mode'] = 'true';
				else
					$data['debug_mode'] = 'false';
				
				$category_data = $this->Layoutmodel2->get_category_data($method);
				$data['method'] = $method;
				$data['urlstem'] = '';
				$data['description'] = 'Learn more about the topic of '.$category_data->name.' at myRight. myRight is a new startup that wants to help everyone learn their rights and know more about the law. Check out the beta release of the site!';
				/*if(sizeof($params) == 1)
				{
					$data['urlstem'] = '../';
					if($data['locget'])
						$data['elements'] = $this->Layoutmodel2->get_tag_loc_elements($category_data->id, $params[0], $data['locget'], $data['offset']);
					else
						$data['elements'] = $this->Layoutmodel2->get_tag_elements($category_data->id, $params[0], $data['offset']);
					if(!$data['offset'])
					{	
						$data['tags'] = $this->Layoutmodel2->get_related_tags($category_data->id, $params[0]);
						$data['taginfo'] = $this->Layoutmodel2->get_tag_info($params[0]);
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
							$data['locations'] = $this->Layoutmodel2->get_tag_locations($category_data->id, $data['taginfo']->id);
					}
					else
					{
						$data['title'] = $method;
					}
				}*/
				if(sizeof($params) == 0)
				{
					$data['test_id'] = $category_data->test_id;
					if($category_data->description !== "")
					{
						$data['top_desc'] = $category_data->description;
						$data['description'] = $category_data->description;
					}
					if($category_data->summary !== "")
					{
						$data['summary'] = $category_data->summary;
					}
					
					if($data['locget'])
						$data['elements'] = $this->Layoutmodel2->get_elements_loc($category_data->id, $data['locget']);
					else
						$data['elements'] = $this->Layoutmodel2->get_elements($category_data->id);
						
					$data['title'] = $category_data->name;
					//$data['tags'] = $this->Layoutmodel2->get_tags($category_data->id);
					
					//Only include location dropdown for location specific categories
					if($method === 'tickets'|| $method === 'dui'|| $method === 'smallclaims')
						$data['locations'] = $this->Layoutmodel2->get_locations($category_data->id);
				}
				else
				{
					show_404();
				}
					

				if($category_data->test_id === "-1")
					$this->load->view('headercategory', $data);
				else
					$this->load->view('header3', $data);
				
				if($method === 'dui')
					$this->load->view('dui', $data);
				else if($method === 'employment')
					$this->load->view('employment', $data);
				else if($category_data->test_id === "0")
					$this->load->view('layoutboardmid', $data);
				else if($category_data->test_id === "-1")
					$this->load->view('startup', $data);
				else
					$this->load->view('layoutmid3', $data);

				if($category_data->test_id === "0")
					$this->load->view('layoutboardbody', $data);
				else if($category_data->test_id === "-1")
					$this->load->view('categorybody', $data);
				else
					$this->load->view('layoutbody4', $data);
					
				$this->load->view('commonscripts', $data);
				$this->load->view('layoutfooter', $data);
			}
			else
			{
				show_404();
			}
		}
	}
}
?>