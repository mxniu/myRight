<?php
class caraccident extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	public function get_test_id($state)
	{
		/*
		//Match up the states with arrays
		$comparative = array("kentucky", "louisiana", "alaska", "arizona", "california", "mississippi", "new-mexico", "new-york", "rhode-island", "south-dakota", "washington", "florida", "missouri");
		$contributory = array("alabama", "dc", "virginia", "maryland", "north-carolina");
		$mod50 = array("tennessee", "colorado", "georgia", "kansas", "oklahoma", "west-virginia", "arkansas", "nebraska", "utah", "maine", "north-dakota");
		//Everything left over...
		$mod51 = array();
	
		if(in_array($state, $comparative))
		{
			return 84;
		}
		else if(in_array($state, $contributory))
		{
			return 87;
		}
		else if(in_array($state, $mod50))
		{
			return 85;
		}
		else
		{
			return 86;
		}*/
		
		return 91;
	}
	
	public function get_bgimage()
	{
		return "bg_road.jpg";
	}
}
?>