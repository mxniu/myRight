<?php
class Admin extends CI_Controller {

	public function index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Adminmodel');
	
		$data['heading'] = 'ADMIN CONSOLE';
		$data['categories'] = $this->Adminmodel->get_categories();
		$data['tags'] = $this->Adminmodel->get_tags();
		
		$this_action = $this->input->post('submit');
		
		if(!$this_action)
		{
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Clear DB Cache")
		{
			$this->Adminmodel->flush_cache();
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Update Tags")
		{
			$this->Adminmodel->build_tags();
			$this->Adminmodel->tag_slugs();
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Load Category")
		{
			$data['category'] = $this->input->post('category');
			$data['elements'] = $this->Adminmodel->get_elements($this->input->post('category'));
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Load Tag")
		{
			$data['tag'] = $this->Adminmodel->get_tag($this->input->post('tag'));
			
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Edit Tag")
		{
			$this->Adminmodel->edit_tag();
			$data['tag'] = $this->Adminmodel->get_tag($this->input->post('id'));
			
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Load Element")
		{
			$data['category'] = $this->input->post('category');
			$data['elements'] = $this->Adminmodel->get_elements($this->input->post('category'));
			$data['element_data'] = $this->Adminmodel->get_element($this->input->post('element'));
			$data['posters'] = $this->Adminmodel->get_posters();
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Add" || $this_action === "Edit" || $this_action === "Delete")
		{	
			$this->form_validation->set_rules('title', 'Title', 'required');
			//$this->form_validation->set_rules('url', 'URL', 'required');
			
			if ($this->form_validation->run() === FALSE)
			{	
				$data['category'] = $this->input->post('category');
				$data['elements'] = $this->Adminmodel->get_elements($this->input->post('category'));
				$data['element_data'] = $this->Adminmodel->get_element($this->input->post('id'));
				$this->load->view('adminview', $data);
			}
			else
			{
				$data['category'] = $this->input->post('category');
				$data['elements'] = $this->Adminmodel->get_elements($this->input->post('category'));
				if($this_action === "Add")
				{
					$this->Adminmodel->create_element();
				}
				else if($this_action === "Edit")
				{
					$this->Adminmodel->edit_element();
				}
				else if($this_action === "Delete")
				{
					$this->Adminmodel->delete_element();
				}
				else
				{
					$data['heading'] = ''.$this_action.' is not yet supported.';				
				}
				
				$cache_to_delete = $this->Adminmodel->get_category_data($this->input->post('category'));
				$this->db->cache_delete($cache_to_delete->slug, 'index');
				
				$this->load->view('adminview', $data);
			}
		
		}
	}
	
	public function test_editor()
	{
		$this->load->helper('form');
		$this->load->model('Adminmodel');

		$data['heading'] = 'TEST EDITOR';
		$data['tests'] = $this->Adminmodel->get_tests();
		
		$this_action = $this->input->post('submit');
		
		if(!$this_action)
		{
			$this->load->view('test_editor', $data);
		}
		else if($this_action === "Load Test")
		{
			$data['test'] = $this->Adminmodel->get_test($this->input->post('test_id'));
		
			$this->load->view('test_editor', $data);
		}
		else if($this_action === "Create Test")
		{
			$this->Adminmodel->create_test($this->input->post('test_id'));
			$data['tests'] = $this->Adminmodel->get_tests();
		
			$this->load->view('test_editor', $data);
		}
		else if($this_action === "Clone Test")
		{
			$this->Adminmodel->clone_test($this->input->post('test_id'));
			$data['tests'] = $this->Adminmodel->get_tests();
		
			$this->load->view('test_editor', $data);
		}
		else if($this_action === "Load Question")
		{
			$data['test'] = $this->Adminmodel->get_test($this->input->post('test_id'));
			$data['question'] = $this->Adminmodel->get_question($this->input->post('id'));
			
			$this->load->view('test_editor', $data);
		}
		else if($this_action === "Add")
		{
			$this->Adminmodel->create_question();
			$data['test'] = $this->Adminmodel->get_test($this->input->post('test_id'));
			
			$this->load->view('test_editor', $data);
		}
		else if($this_action === "Edit")
		{
			$this->Adminmodel->edit_question();
			$data['test'] = $this->Adminmodel->get_test($this->input->post('test_id'));
			
			$this->load->view('test_editor', $data);
		}
		else if($this_action === "Delete")
		{
			$this->Adminmodel->delete_question();
			$data['test'] = $this->Adminmodel->get_test($this->input->post('test_id'));
			
			$this->load->view('test_editor', $data);
		}
	}
	
	public function view_stats()
	{	
		$this->load->helper('form');
		$this->load->model('Adminmodel');

		$data['heading'] = 'myRight Analytics';
		$data['tests'] = $this->Adminmodel->get_tests_by_version(2);
		
		$this_action = $this->input->post('submit');
		
		if(!$this_action)
		{
			//Do nothing
		}
		else if($this_action === "Get Test")
		{
			$data['test'] = $this->Adminmodel->get_test(91);
			$data['results'] = $this->Adminmodel->get_stats(91);
		}
		
		$this->load->view('analytics', $data);
		/*echo "<b>Test 66:</b><br/>";
		echo "Total visitors: ".$results['total']."<br/>";
		echo "Bounce Rate: ".$results['bounce_rate']."%<br/>";
		echo "Average Time per User (non-bounce users): ".$results['time_spent']." minutes<br/>";
		echo "Average Time per Visit (non-bounce users): ".$results['time_per_visit']." minutes<br/>";
		echo "Average Engagement Depth (non-bounce users): ".$results['engagement']." clicks per user<br/>";
		echo "Visits per User (non-bounce users): ".$results['revisits']." visits per user<br/>";*/
	}
}
?>