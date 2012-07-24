<?php
class Fbcontrol extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        $this->load->model('Fbmodel');
    }
 
    function index()
    {
		$this->load->helper('url');
        $fb_data = $this->session->userdata('fb_data'); // This array contains all the user FB information
 
        if((!$fb_data['uid']) or (!$fb_data['me']))
        {
            // If this is a protected section that needs user authentication
            // you can redirect the user somewhere else
            // or take any other action you need
            $this->load->view('fbview', $data);
        }
        else
        {
            $data = array(
                    'fb_data' => $fb_data,
                    );
 
            $this->load->view('fbview', $data);
        }
    }
}
?>