<?php
class Viewscreen extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function _remap($method)
	{
		$this->load->model('Commonmodel');
		$this->load->model('Viewmodel');
		$data['method'] = $method;
		$data['element'] = $this->Viewmodel->get_element($method);
		if($data['element'])
		{
			if($data['element']->poster != "0")
			{
				$data['poster'] = $this->Viewmodel->get_poster($data['element']->poster);
			}
			else
				$data['poster'] = 0;
			$data['title'] = $data['element']->title;
			$data['description'] = strip_tags($data['element']->summary);
			$data['category'] = $this->Viewmodel->get_category_data($data['element']->category);
			
			$this->Viewmodel->add_view($data['element']->id, $data['element']->views);
			
			/*if($data['category']->version === "1")
			{*/
				//OLD VERSION OF VIEWPORT
				
				$this->load->view('viewheader', $data);
				if($method === "america-vs-marijuana-a-battle-for-state-rights")
					$this->load->view('america-vs-marijuana-a-battle-for-state-rights', $data);
				else
					$this->load->view('viewport', $data);
				$this->load->view('viewscripts', $data);
				$this->load->view('commonscripts', $data);
				$this->load->view('layoutfooter');
			//}
			/*else if($data['category']->version === "2")
			{
				//VERSION 2 OF VIEWPORT
				//12/10/12
				
				$this->load->view('viewheader2', $data);
				$this->load->view('viewport2', $data);
				//Load any custom scripts, if they are specified...
				if($data['category']->script)
				{
					$this->output->append_output("<script type='text/javascript' src='/js/".$data['category']->script.".js'></script>");
					$this->output->append_output("<div class='hidden' id='ignition_trigger'></div>");
				}
				$this->load->view('commonscripts', $data);
				$this->load->view('layoutfooter');
			}*/
		}
		else if($method === "marijuana-laws-infographic")
		{
			$data['poster'] = 0;
			$data['title'] = "Marijuana Laws Infographic";
			$data['description'] = "Check out this marijuana infographic to learn about where marijuana laws stand across the United States.";
		
			$this->load->view('viewheader', $data);
			$this->load->view('marijuana-laws-infographic', $data);
			$this->load->view('viewscripts', $data);
			$this->load->view('commonscripts', $data);
			$this->load->view('layoutfooter');
		}
		else
		{
			show_404();
		}
	}
}
?>