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
		/*else if($method === 'marijuana')
		{
			show_404();
		}*/
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
				//Default relid to be -1 so as not to trigger anything if not re-set below
				$data['category'] = $category_data;
				$data['relid'] = -1;
				$data['method'] = $method;
				$data['urlstem'] = '';
				$data['bgimage'] = '';
				$data['description'] = 'Learn more about the topic of '.$category_data->name.' at myRight. myRight is a new startup that wants to help everyone learn their rights and know more about the law.';
				if(sizeof($params) == 0)
				{
					//There is no state parameter, use old procedure
					
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
					else if($category_data->rel != "0")
					{
						$data['elements'] = $this->Layoutmodel2->get_elements_rel($category_data->id, $category_data->rel);
						$data['relslug'] = $this->Layoutmodel2->get_rel_slug($category_data->rel);
						$data['relid'] = $category_data->rel;
					}
					else
						$data['elements'] = $this->Layoutmodel2->get_elements($category_data->id);
						
					$data['title'] = $category_data->name;
					
					//Only include location dropdown for location specific categories
					if($method === 'tickets'|| $method === 'dui'|| $method === 'smallclaims')
						$data['locations'] = $this->Layoutmodel2->get_locations($category_data->id);
				}
				else
				{
					//Because of routing script, this MUST be a state sub-url.. use custom procedure
				
					$stripped_method = str_replace('-', '', $method);
					$this->load->model($stripped_method);
					$this->load->model('Statefunctions');
					
					$data['test_id'] = $this->$stripped_method->get_test_id($params[0]);
					$data['bgimage'] = $this->$stripped_method->get_bgimage();
					$data['state_name'] = $this->Statefunctions->get_name_from_slug($params[0]);
					$data['state_id'] = $this->Statefunctions->get_acronym_from_slug($params[0]);
					$data['title'] = $category_data->name." - ".$data['state_name'];
					$data['description'] = $this->Statefunctions->get_description($category_data->id, $data['state_id']);
					//$data['description'] = 'Learn more your rights when you face a '.$category_data->name.' in '.$data['state_name'].'. If you have been injured in a car accident, or any other auto accident involving a bus, truck, tractor, or other vehicles, you may be entitled to justice and the right to get your fair share of compensation. An accident lawyer or personal injury attorney can help show that you were not at fault may prove that another driver caused the accident. Each state has slightly different laws regarding accident injuries, so use the myRight '.$category_data->name.' Guide to learn more about the laws in '.$data['state_name'];
					
					$data['elements'] = $this->Layoutmodel2->get_elements_rel($category_data->id, $category_data->id);
					$data['relslug'] = $this->Layoutmodel2->get_rel_slug($category_data->id);
					$data['relid'] = $category_data->id;
				}
					

				if(sizeof($params) === 1)
				{
					//There is a state, therefore this must be a state page..
					if($category_data->version === "1")
					{
						$this->load->view('header3', $data);
						$this->load->view('layoutmid3', $data);
						$this->load->view('layoutbody4', $data);
					}
					else if($category_data->version === "2")
					{
						$this->load->view('testheader6', $data);
						$this->load->view('testmid6', $data);
						$this->load->view('statebody6', $data);
					}
					
					$this->output->append_output("<div class='hidden' id='state_id'>".$data['state_id']."</div>");
				}
				else if($category_data->version === "2")
				{
					$this->load->view('testheader6', $data);
					if($category_data->test_id === "0")
						$this->load->view('comingsoon6', $data);
					else if($method === "employment-discrimination")
					{
						$this->load->view('testmid6', $data);
						$this->load->view('testbody6', $data);
					}
					else
					{
						$this->load->view('car-accident', $data);
						$this->load->view('testbody6', $data);
					}
				}
				else
				{
					//No state paramter means more must be done to figure out the nature of the file
					if($category_data->test_id === "-1")
						$this->load->view('headercategory', $data);
					else if($method === 'gun-rights')
						$this->load->view('gunheader', $data);
					else
						$this->load->view('header3', $data);
					
					//Need to reorganize this section later
					if($method === 'dui')
						$this->load->view('dui', $data);
					else if($method === 'employment')
						$this->load->view('employment', $data);
					else if($method === 'car-accident')
						$this->load->view('car-accident', $data);
					else if($method === 'marijuana')
						$this->load->view('marijuana', $data);
					else if($method === 'gun-rights')
						$this->load->view('gun-rights', $data);
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
				}
				
				//Load any custom scripts, if they are specified...
				if($category_data->script)
				{
					$this->output->append_output("<script type='text/javascript' src='/js/".$category_data->script.".js'></script>");
					$this->output->append_output("<div class='hidden' id='ignition_trigger'></div>");
				}
				
				//Common to all layouts
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