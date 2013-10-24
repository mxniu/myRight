<?php
class Functioning extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function vote()
	{
		$this->load->model('Functionmodel');
		$this_action = $this->input->post('action');
		$this_id = $this->input->post('id');
		$this_votes = $this->input->post('votes');
		
		return $this->Functionmodel->voterun($this_action, $this_id, $this_votes);
	}
	
	public function find_slug()
	{
		$this->load->model('Functionmodel');
		$tag = $this->input->post('tag');
		
		return $this->Functionmodel->slug_from_tag($tag);
	}
	
	public function show_terms()
	{
		$this->load->view('termsofuse');
	}
	
	public function show_disclaimer() 
	{
		$this->load->view('disclaimer'); 
	}
	
	public function show_privacy() 
	{
		$this->load->view('privacy'); 
	}
	public function show_about() 
	{
		$this->load->view('about'); 
	}
	
	public function get_issue()
	{
		$this->load->model('Functionmodel');
		$test_id = $this->input->post('test_id');
		
		return $this->Functionmodel->get_test_questions($test_id);
	}
	
	public function tracker()
	{
		$this->load->model('Functionmodel');
	
		$this->Functionmodel->track_entry();
	}
	
	public function submit_results()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$test_id = $this->input->post('test_id');
	
		if(!trim($name))
		{
			echo "Please enter your name";
		}
		else if(!trim($email) && !trim($phone))
		{
			echo "Please enter an e-mail address or phone number";
		}
		else if(trim($email) && !filter_var(trim($email), FILTER_VALIDATE_EMAIL)) 
		{
			echo "E-mail address is invalid";
		}
		else if(trim($phone) && !preg_match("/^[0-9]{10}$/", trim($phone)))
		{
			echo "Phone number is invalid. Do not include dashes.";
		}
		else
		{
			$this->load->model('Functionmodel');
			
			$test_name = $this->Functionmodel->test_name_from_id($test_id);
			//define the receiver of the email
			$to = 'info@myright.me';
			//define the subject of the email
			$subject = 'Lead Notification'; 
			//define the message to be sent. Each line should be separated with \n
			$message = "Lead Notification\n\nTest Name:".$test_name->name."\n\nName:".$name."\n".$email."\nPhone:".$phone; 
			//define the headers we want passed. Note that they are separated with \r\n
			$headers = "From: info@myright.me\r\nReply-To: info@myright.me";
			//send the email
			$mail_sent = @mail( $to, $subject, $message, $headers );
			
			return $this->Functionmodel->insert_lead($name, $email, $phone, $test_id);
		}
	}
	
	public function discrimination_eligibility()
	{
		$state = $this->input->post('state');
		$age = $this->input->post('age');
		$classes = explode("|", $this->input->post('classes'));
		$incident_date = $this->input->post('incident_date');
		$type = $this->input->post('type');
		$num_employees = $this->input->post('num_employees');
		$raw_score = $this->input->post('raw_score');
		$alt_calc = $this->input->post('alt_calc');
		
		$this->load->model('Discrimination');

		$this->Discrimination->get_result($state, $age, $classes, $incident_date, $type, $num_employees, $raw_score, $alt_calc);
	}
}
?>