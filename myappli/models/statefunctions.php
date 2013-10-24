<?php
class Statefunctions extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	function get_name_from_slug($slug)
	{
		switch ($slug)
		{
			case "alabama": return "Alabama"; break;
			case "alaska": return "Alaska"; break;
			case "arizona": return "Arizona"; break;
			case "arkansas": return "Arkansas"; break;
			case "california": return "California"; break;
			case "colorado": return "Colorado"; break;
			case "connecticut": return "Connecticut"; break;
			case "delaware": return "Delaware"; break;
			case "dc": return "DC"; break;
			case "florida": return "Florida"; break;
			case "georgia": return "Georgia"; break;
			case "hawaii": return "Hawaii"; break;
			case "idaho": return "Idaho"; break;
			case "illinois": return "Illinois"; break;
			case "indiana": return "Indiana"; break;
			case "iowa": return "Iowa"; break;
			case "kansas": return "Kansas"; break;
			case "kentucky": return "Kentucky"; break;
			case "louisiana": return "Louisiana"; break;
			case "maine": return "Maine"; break;
			case "maryland": return "Maryland"; break;
			case "massachusetts": return "Massachusetts"; break;
			case "michigan": return "Michigan"; break;
			case "minnesota": return "Minnesota"; break;
			case "mississippi": return "Mississippi"; break;
			case "missouri": return "Missouri"; break;
			case "montana": return "Montana"; break;
			case "nebraska": return "Nebraska"; break;
			case "nevada": return "Nevada"; break;
			case "new-hampshire": return "New Hampshire"; break;
			case "new-jersey": return "New Jersey"; break;
			case "new-mexico": return "New Mexico"; break;
			case "new-york": return "New York"; break;
			case "north-carolina": return "North Carolina"; break;
			case "north-dakota": return "North Dakota"; break;
			case "ohio": return "Ohio"; break;
			case "oklahoma": return "Oklahoma"; break;
			case "oregon": return "Oregon"; break;
			case "pennsylvania": return "Pennsylvania"; break;
			case "rhode-island": return "Rhode Island"; break;
			case "south-carolina": return "South Carolina"; break;
			case "south-dakota": return "South Dakota"; break;
			case "tennessee": return "Tennessee"; break;
			case "texas": return "Texas"; break;
			case "utah": return "Utah"; break;
			case "vermont": return "Vermont"; break;
			case "virginia": return "Virginia"; break;
			case "washington": return "Washington"; break;
			case "west-virginia": return "West Virginia"; break;
			case "wisconsin": return "Wisconsin"; break;
			case "wyoming": return "Wyoming"; break;
		}
	}
	
	function get_acronym_from_slug($slug)
	{
		switch ($slug)
		{
			case "alabama": return "AL"; break;
			case "alaska": return "AK"; break;
			case "arizona": return "AZ"; break;
			case "arkansas": return "AR"; break;
			case "california": return "CA"; break;
			case "colorado": return "CO"; break;
			case "connecticut": return "CT"; break;
			case "delaware": return "DE"; break;
			case "dc": return "DC"; break;
			case "florida": return "FL"; break;
			case "georgia": return "GA"; break;
			case "hawaii": return "HI"; break;
			case "idaho": return "ID"; break;
			case "illinois": return "IL"; break;
			case "indiana": return "IN"; break;
			case "iowa": return "IA"; break;
			case "kansas": return "KS"; break;
			case "kentucky": return "KY"; break;
			case "louisiana": return "LA"; break;
			case "maine": return "ME"; break;
			case "maryland": return "MD"; break;
			case "massachusetts": return "MA"; break;
			case "michigan": return "MI"; break;
			case "minnesota": return "MN"; break;
			case "mississippi": return "MS"; break;
			case "missouri": return "MO"; break;
			case "montana": return "MT"; break;
			case "nebraska": return "NE"; break;
			case "nevada": return "NV"; break;
			case "new-hampshire": return "NH"; break;
			case "new-jersey": return "NJ"; break;
			case "new-mexico": return "NM"; break;
			case "new-york": return "NY"; break;
			case "north-carolina": return "NC"; break;
			case "north-dakota": return "ND"; break;
			case "ohio": return "OH"; break;
			case "oklahoma": return "OK"; break;
			case "oregon": return "OR"; break;
			case "pennsylvania": return "PA"; break;
			case "rhode-island": return "RI"; break;
			case "south-carolina": return "SC"; break;
			case "south-dakota": return "SD"; break;
			case "tennessee": return "TN"; break;
			case "texas": return "TX"; break;
			case "utah": return "UT"; break;
			case "vermont": return "VT"; break;
			case "virginia": return "VA"; break;
			case "washington": return "WA"; break;
			case "west-virginia": return "WV"; break;
			case "wisconsin": return "WI"; break;
			case "wyoming": return "WY"; break;
		}
	}
	
	function get_description($category, $state_id)
	{
		$query = $this->db->query("SELECT description FROM state_descriptions WHERE category = {$category} AND state = '{$state_id}'");
		return $query->row()->description;
	}
	
	function fix_everything()
	{
		$search = array(chr(145), 
                    chr(146), 
                    chr(147), 
                    chr(148), 
                    chr(151)); 

		$replace = array("'", 
						 "'", 
						 '"', 
						 '"', 
						 '-'); 
	
		$query = $this->db->query("SELECT id, description FROM state_descriptions");
		
		foreach ($query->result() as $row)
		{
			$row_id = $row->id;
			$new_description = str_replace($search, $replace, $row->description); 
		
			$this->db->query("UPDATE state_descriptions SET description = '{$new_description}' WHERE id = {$row_id}");	
		}
		
		return;
	}
}
?>