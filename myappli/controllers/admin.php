<?php
class Admin extends CI_Controller {

	public function index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('Adminmodel');
	
		$data['heading'] = 'ADMIN CONSOLE';
		$data['categories'] = $this->Adminmodel->get_categories();
		
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
		else if($this_action === "Load Element")
		{
			$data['category'] = $this->input->post('category');
			$data['elements'] = $this->Adminmodel->get_elements($this->input->post('category'));
			$data['element_data'] = $this->Adminmodel->get_element($this->input->post('element'));
			$this->load->view('adminview', $data);
		}
		else if($this_action === "Add" || $this_action === "Edit" || $this_action === "Delete")
		{	
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('summary', 'Summary', 'required');
			$this->form_validation->set_rules('url', 'URL', 'required');
			
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
}
?>