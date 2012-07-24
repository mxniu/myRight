<?php
class Bah extends CI_Controller {

	public function index()
	{
		$this->load->view('newview', $data);
	}
	
	public function _remap($method)
	{
		if($method == "")
		{
			$this->index();
		}
		else
		{
			$data['uri'] = $method;
			
			$this->load->view('newview', $data);
		}	
	}
	
	public function shoes($sandals, $id)
    {
        echo $sandals;
        echo $id;
    }
}
?>