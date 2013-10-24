<?php
class Discrimination extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	function get_result($state, $age, $classes, $incident_date, $type, $num_employees, $raw_score, $alt_calc)
	{
		if(!$classes[0])
		{
			$return_arr = array('score' => $raw_score, 'result' => "According to your answers, you do not fall under a protected class. A lawyer can help you determine whether you are part of a protected class not covered by our questions. Be sure to act fast because there is a deadline for filing claims called the statute of limitations.");
			echo json_encode($return_arr);
			return;
		}
	
		$output_text = "";
		$output_scores = array();
	
		foreach($classes as $protected_class)
		{
			$output_score = $raw_score;
		
			$protection = $this->Discrimination->class_protection($state, $protected_class);
			//$output_text .= "Protection status: ".$protection;
			
			$emp_eligible = $this->Discrimination->emp_thresholds($state, $num_employees, $protected_class, $type);
			//$output_text .= "Employee threshold status: ".$emp_eligible;
			$sol_eligible = $this->Discrimination->check_sol($state, $protected_class, $incident_date);
			//$output_text .= "SOL status: ".$sol_eligible;
			
			$output_text .= "For your {$protected_class} claim, ";
			
			if($protected_class === "AGE")
			{
				$age_eligible = $this->Discrimination->age_eligibility($state, $age);
				//$output_text .= "Age status: ".$age_eligible;
				
				if($protection === 3 && $emp_eligible === 3 && $sol_eligible === 3 && $age_eligible === 3)
				{
					$output_text .= "you are likely eligible to file a claim with both federal and state agencies.";
				}
				else if($protection === 0 || $emp_eligible === 0 || $sol_eligible === 0 || $age_eligible === 0)
				{
					$output_text .= "you are likely not eligible to file a claim with either federal or state agencies.";
					
					if($alt_calc === "0")
					{
						$negative_mod = 0.5;
							if($protection === 0)
								$negative_mod -= 0.1;
							if($emp_eligible === 0)
								$negative_mod -= 0.1;
							if($sol_eligible === 0)
								$negative_mod -= 0.1;
							if($age_eligible === 0)
								$negative_mod -= 0.1;
							
						$output_score *= $negative_mod;
					}
				}
				else if($protection >= 2 && $emp_eligible >= 2 && $sol_eligible >= 2 && $age_eligible >= 2)
				{
					$output_text .= "you are likely eligible to file a claim with a state agency, but not a federal agency.";
				}
				else if(($protection === 1 || $protection === 3) && ($emp_eligible === 1 || $emp_eligible === 3) && ($sol_eligible === 1 || $sol_eligible === 3) && ($age_eligible === 1 || $age_eligible === 3))
				{
					$output_text .= "you are likely eligible to file a claim with a federal agency, but not a state agency.";
				}
				else
				{
					$output_text .= "you are likely not eligible to file a claim with either federal or state agencies.";
				}
				
				if($alt_calc === "1")
				{
					$num_satisfied = 0;
					if($protection >= 1)
						$num_satisfied++;
					if($emp_eligible >= 1)
						$num_satisfied++;
					if($sol_eligible >= 1)
						$num_satisfied++;
					if($age_eligible >= 1)
						$num_satisfied++;
					
					if($num_satisfied === 0)
						$output_score = 1;
					else if($num_satisfied === 1)
						$output_score = 2;
					else if($num_satisfied === 2)
						$output_score = 3;
					else if($num_satisfied === 3)
						$output_score = 4;
					else if($num_satisfied === 4)
						$output_score = 10;
				}
			}
			else
			{
				if($protection === 3 && $emp_eligible === 3 && $sol_eligible === 3)
				{
					$output_text .= "you are likely eligible to file a claim with both federal and state agencies.";
				}
				else if($protection === 0 || $emp_eligible === 0 || $sol_eligible === 0)
				{
					$output_text .= "you are likely not eligible to file a claim with either federal or state agencies.";
					
					if($alt_calc === "0")
					{
						$negative_mod = 0.4;
							if($protection === 0)
								$negative_mod -= 0.1;
							if($emp_eligible === 0)
								$negative_mod -= 0.1;
							if($sol_eligible === 0)
								$negative_mod -= 0.1;
							
						$output_score *= $negative_mod;
					}
				}
				else if($protection >= 2 && $emp_eligible >= 2 && $sol_eligible >= 2)
				{
					$output_text .= "you are likely eligible to file a claim with a state agency, but not a federal agency.";
				}
				else if(($protection === 1 || $protection === 3) && ($emp_eligible === 1 || $emp_eligible === 3) && ($sol_eligible === 1 || $sol_eligible === 3))
				{
					$output_text .= "you are likely eligible to file a claim with a federal agency, but not a state agency.";
				}
				else
				{
					$output_text .= "you are likely not eligible to file a claim with either federal or state agencies.";
				}
				
				if($alt_calc === "1")
				{
					$num_satisfied = 0;
					if($protection >= 1)
						$num_satisfied++;
					if($emp_eligible >= 1)
						$num_satisfied++;
					if($sol_eligible >= 1)
						$num_satisfied++;
					
					if($num_satisfied === 0)
						$output_score = 1;
					else if($num_satisfied === 1)
						$output_score = 2;
					else if($num_satisfied === 2)
						$output_score = 3;
					else if($num_satisfied === 3)
						$output_score = 10;
				}
			}
			
			$output_text .= "<br/><br/>";
			$output_scores[] = $output_score;
		}
		
		$output_text .= '<div style="font-size: 0.8em; line-height: 1.2em; color: #444;">Keep in mind that our questions are not comprehensive. Always contact a local lawyer to learn more about your employment rights and to help you make the right decisions about your case. Be sure to act fast because there is a deadline for filing claims called the statute of limitations.</div>';
		
		if($alt_calc === "0")
			$return_arr = array('score' => max($output_scores), 'result' => $output_text);
		else
			$return_arr = array('score' => ((array_sum($output_scores)/count($output_scores)) * $raw_score), 'result' => $output_text);
		echo json_encode($return_arr);
	}
	
	function age_eligibility($state, $age)
	{
		//0=not eligible, 1 = fed eligible only, 2 = state eligible only, 3 = both
		$fed_eligible = false;
		$state_eligible = false;
	
		//Test against federal first (fed = 40)
		if($age >= 40)
		{
			$fed_eligible = true;
		}
		
		//Else compare to state range
		$agenorange = array('AK', 'MT', 'NH', 'ME', 'MD', 'MI', 'HI');
		$agenolaw = array('AR', 'MS', 'SD');
		$age18 = array('IA', 'CT', 'NY', 'VT', 'MN', 'OR', 'DC');
		$age1870 = array('NJ');
		$age40 = array('AL', 'IL', 'PA', 'RI', 'AZ', 'NE', 'SC', 'KS', 'CA', 'KY', 'TN', 'LA', 'TX', 'NM', 'UT', 'DE', 'FL', 'MA', 'NC', 'VA', 'ND', 'WA', 'OH', 'WV', 'ID', 'OK', 'WI', 'WY');
		$age4070 = array('MO', 'CO', 'GA');
		$age4075 = array('IN');
		
		if(in_array($state, $agenolaw))
		{
			$state_eligible = false;
		}
		else if (in_array($state, $agenorange))
		{
			$state_eligible = true;
		}
		else if (in_array($state, $age18))
		{
			if($age >= 18)
				$state_eligible = true;
			else
				$state_eligible = false;
		}
		else if (in_array($state, $age1870))
		{
			if($age >= 18 && $age < 70)
				$state_eligible = true;
			else
				$state_eligible = false;
		}
		else if (in_array($state, $age40))
		{
			if($age >= 40)
				$state_eligible = true;
			else
				$state_eligible = false;
		}
		else if (in_array($state, $age4070))
		{
			if($age >= 40 && $age < 70)
				$state_eligible = true;
			else
				$state_eligible = false;
		}
		else if (in_array($state, $age4075))
		{
			if($age >= 18 && $age < 75)
				$state_eligible = true;
			else
				$state_eligible = false;
		}
		else
			$state_eligible = false;
			
		if($state_eligible && $fed_eligible)
			return 3;
		else if($state_eligible)
			return 2;
		else if($fed_eligible)
			return 1;
		else
			return 0;
	}
	
	function emp_thresholds($state, $num_employees, $protected_class, $type)
	{
		$fed_threshold = 0;
		$state_threshold = 0;
	
		if($type === "DISCRIM" || $protected_class !== "SEX")
		{
			//This is discrimination OR it is equal pay for something other than sex
		
			$fed_threshold = 15;
			switch($protected_class)
			{
				case "AGE":
					$fed_threshold = 20;
					break;
				case "MILITARY":
					$fed_threshold = 1;
					break;
				case "IMMIGRATION":
					$fed_threshold = 4;
					break;
				case "NATIONAL ORIGIN":
					$fed_threshold = 4;
					break;
			}
			
			$state_thresholds = array('LA' => 20, 'IL' => 15, 'AZ' => 15, 'NE' => 15, 'SC' => 15, 'NV' => 15, 'TX' => 15, 'UT' => 15, 'MD' => 15, 'FL' => 15, 'NC' => 15, 'VA' => 15, 'GA' => 15, 'OK' => 15, 'WV' => 12, 'AR' => 9, 'KY' => 8, 'TN' => 8, 'WA' => 8, 'MO' => 6, 'IN' => 6, 'NH' => 6, 'MA' => 6, 'CA' => 5, 'ID' => 5, 'PA' => 4, 'RI' => 4, 'IA' => 4, 'KS' => 4, 'NM' => 4, 'DE' => 4, 'NY' => 4, 'OH' => 4, 'CT' => 3, 'WY' => 2, 'AK' => 1, 'MT' => 1, 'SD' => 1, 'CO' => 1, 'NJ' => 1, 'ME' => 1, 'VT' => 1, 'MI' => 1, 'ND' => 1, 'HI' => 1, 'MN' => 1, 'MS' => 1, 'DC' => 1, 'OR' => 1, 'WI' => 1, 'AL' => 0);
			
			$state_threshold = $state_thresholds[$state];
			switch($state)
			{
				case "AZ":
					if($protected_class === "SEX") 
						$state_threshold = 1;
					break;
				case "NE":
					if($protected_class === "AGE") 
						$state_threshold = 20;
					break;
				case "NM":
					if($protected_class === "SEXUAL ORIENTATION") 
						$state_threshold = 15;
					break;
				case "WA":
					if($protected_class === "AGE") 
						$state_threshold = 1;
					break;
				case "VA":
					if($protected_class === "TERMINATED") 
						$state_threshold = 6;
					break;
			}
		}
		else if($type === "EQPAY")
		{
			//EPA for sex only, 15 for Title VII
			$fed_threshold = 2;
		
			$eqpay_thresholds = array('LA' => 20, 'SC' => 15, 'TX' => 15, 'UT' => 15, 'NC' => 15, 'NE' => 15, 'GA' => 10, 'MA' => 6, 'VA' => 6, 'IA' => 4, 'NM' => 4, 'IL' => 4, 'IN' => 2, 'KY' => 2, 'FL' => 2, 'ND' => 2, 'WA' => 2, 'AK' => 1, 'VT' => 1, 'MS' => 1, 'WI' => 1, 'DC' => 1, 'MO' => 1, 'PA' => 1, 'MT' => 1, 'RI' => 1, 'AZ' => 1, 'AR' => 1, 'KS' => 1, 'NV' => 1, 'SD' => 1, 'CA' => 1, 'NH' => 1, 'TN' => 1, 'CO' => 1, 'NJ' => 1, 'CT' => 1, 'ME' => 1, 'DE' => 1, 'MD' => 1, 'NY' => 1, 'MI' => 1, 'HI' => 1, 'MN' => 1, 'OH' => 1, 'WV' => 1, 'ID' => 1, 'OK' => 1, 'OR' => 1, 'WY' => 1, 'AL' => 0);

			$state_threshold = $eqpay_thresholds[$state];
		}
		else
			return -1; //Error code
			
		if($num_employees >= $fed_threshold)
			$fed_eligible = true;
		else
			$fed_eligible = false;
			
		if($num_employees >= $state_threshold)
			$state_eligible = true;
		else
			$state_eligible = false;
		
		if($fed_eligible && $state_eligible)
			return 3;
		else if($state_eligible)
			return 2;
		else if($fed_eligible)
			return 1;
		else
			return 0;
	}
	
	function class_protection($state, $protected_class)
	{
		$fed_protection = false;
		$state_protection = false;
		
		$fed_classes = array('RACE', 'NATIONAL ORIGIN', 'RELIGION', 'SEX', 'AGE', 'DISABILITY', 'MEDICAL RECORD');
		$class_by_state = array();
	
		$class_by_state['RACE'] = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$class_by_state['NATIONAL ORIGIN'] = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$class_by_state['RELIGION'] = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$class_by_state['SEX'] = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$class_by_state['AGE'] = array('AL', 'AK', 'AZ', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'TN', 'UT', 'TX', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$class_by_state['DISABILITY'] = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$class_by_state['HEIGHT/WEIGHT'] = array('MI');
		$class_by_state['SEXUAL ORIENTATION'] = array('CA', 'CO', 'CT', 'DE', 'HI', 'IL', 'IA', 'ME', 'MD', 'MA', 'MN', 'NV', 'NH', 'NJ', 'NM', 'NY', 'OR', 'RI', 'VT', 'WA', 'WI');
		$class_by_state['MARITAL STATUS'] = array('AK', 'CA', 'CT', 'DE', 'FL', 'HI', 'IL', 'MD', 'MA', 'MI', 'MN', 'MT', 'NE', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OR', 'VA', 'WA', 'WI');
		$class_by_state['MILITARY STATUS'] = array('IL', 'KS', 'MA', 'MS', 'NC', 'NJ', 'NY', 'NC', 'OK', 'WI', 'WY');
		$class_by_state['POLITICAL ACTIVITY'] = array('CA');
		$class_by_state['ARREST RECORD'] = array('HI', 'IL', 'MA', 'MI', 'WI');
		$class_by_state['SMOKER'] = array('IN', 'KY', 'MS', 'MO', 'NJ', 'OH', 'PA', 'WV', 'WY', 'OK', 'RI');
		$class_by_state['IMMIGRATION STATUS'] = array('IN', 'LA', 'ME');
		$class_by_state['MEDICAL RECORD'] = array('AZ', 'AR', 'CA', 'CT', 'DE', 'HI', 'ID', 'IL', 'IA', 'KS', 'MD', 'MA', 'MI', 'MN', 'MO', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'OK', 'OR', 'PA', 'RI', 'SD', 'TX', 'UT', 'VT', 'VA', 'WA', 'WI');
		
		if(in_array($protected_class, $fed_classes))
		{
			$fed_protection = true;
		}
		
		if(!isset($class_by_state[$protected_class]))
		{
			$state_protection = false;
		}
		else if(in_array($state, $class_by_state[$protected_class]))
		{
			$state_protection = true;
		}
		
		if($fed_protection && $state_protection)
			return 3;
		else if($state_protection)
			return 2;
		else if($fed_protection)
			return 1;
		else
			return 0;
	}
	
	function check_sol($state, $protected_class, $incident_date)
	{
		$fed_sol = 0;
		$state_sol = 0;
	
		$protection = $this->class_protection($state, $protected_class);
	
		if($protection === 3)
		{
			$fed_sol = 300;
		}
		else if($protection === 1)
		{
			$fed_sol = 180;
		}
		else
		{
			//No federal protection
		}
	
		if($protection >= 2)
		{
			$solnoagency = array('AL', 'AR', 'NC', 'GA', 'MS');
			if(in_array($state, $solnoagency))
			{
				//No agency.. no state protection
			}
			else
			{
				$sol = array('RI' => 365, 'CA' => 365, 'NY' => 365, 'VT' => 365, 'FL' => 365, 'MN' => 365, 'ID' => 365, 'DC' => 365, 'OR' => 365, 'IA' => 300, 'NE' => 300, 'NV' => 300, 'ME' => 300, 'MA' => 300, 'ND' => 300, 'WI' => 300, 'IL' => 180, 'MO' => 180, 'PA' => 180, 'AK' => 180, 'IN' => 180, 'MT' => 180, 'AZ' => 180, 'SC' => 180, 'KS' => 180, 'SD' => 180, 'KY' => 180, 'NH' => 180, 'TN' => 180, 'CO' => 180, 'LA' => 180, 'NJ' => 180, 'TX' => 180, 'CT' => 180, 'NM' => 180, 'UT' => 180, 'MD' => 180, 'VA' => 180, 'MI' => 180, 'WA' => 180, 'HI' => 180, 'OH' => 180, 'OK' => 180, 'WY' => 180, 'WV' => 165, 'DE' => 120);
				
				$state_sol = $sol[$state];
			}
		}
		else
		{
			$state_sol = 0;
		}
		
		//Convert to seconds (instead of milliseconds)
		$incident_date = $incident_date / 1000;
		//One day in seconds
		$oneDay = 24*60*60;
		
		//Calculate the "last day"
		$state_lastday = $incident_date + ($oneDay * $state_sol);
		$fed_lastday = $incident_date + ($oneDay * $fed_sol);
		
		//Check if last day is a weekend.. (ignoring federal holidays because schedule changes often)
		while(date('N', $state_lastday) >= 6)
		{
			$state_lastday += $oneDay;
		}
		while(date('N', $fed_lastday) >= 6)
		{
			$fed_lastday += $oneDay;
		}
		
		/*if($protection >= 1)
		{
			echo "Last days to file: ";
			if($protection >= 2)
				echo "State(".date('l, M d, Y', $state_lastday).")[".$state_lastday."]";
			if($protection === 1 || $protection === 3)
				echo "Federal(".date('l, M d, Y', $fed_lastday).")";
		}*/
			
		//Calculate "today"
		$today = strtotime('today');
		
		if($fed_lastday >= $today && ($protection === 3 || $protection === 1))
			$fed_eligible = true;
		else
			$fed_eligible = false;
			
		if($state_lastday >= $today && ($protection === 3 || $protection === 2))
			$state_eligible = true;
		else
			$state_eligible = false;
		
		if($fed_eligible && $state_eligible)
			return 3;
		else if($state_eligible)
			return 2;
		else if($fed_eligible)
			return 1;
		else
			return 0;
	}
	
	/*function get_data($state)
	{
		$data = array();
		
		$racecolor = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$natorigin = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$religion = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$sex = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$age = array('AL', 'AK', 'AZ', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'TN', 'UT', 'TX', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$disability = array('AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
		$heightorweight = array('MI');
		$sexualorientation = array('CA', 'CO', 'CT', 'DE', 'HI', 'IL', 'IA', 'ME', 'MD', 'MA', 'MN', 'NV', 'NH', 'NJ', 'NM', 'NY', 'OR', 'RI', 'VT', 'WA', 'WI');
		$maritalstatus = array('AK', 'CA', 'CT', 'DE', 'FL', 'HI', 'IL', 'MD', 'MA', 'MI', 'MN', 'MT', 'NE', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OR', 'VA', 'WA', 'WI');
		$military = array('IL', 'KS', 'MA', 'MS', 'NC', 'NJ', 'NY', 'NC', 'OK', 'WI', 'WY');
		$politicalactivity = array('CA');
		$arrestrecord = array('HI', 'IL', 'MA', 'MI', 'WI');
		$smoker = array('IN', 'KY', 'MS', 'MO', 'NJ', 'OH', 'PA', 'WV', 'WY', 'OK', 'RI');
		$immigrationstatus = array('IN', 'LA', 'ME');
		$medhistory = array('AZ', 'AR', 'CA', 'CT', 'DE', 'HI', 'ID', 'IL', 'IA', 'KS', 'MD', 'MA', 'MI', 'MN', 'MO', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'OK', 'OR', 'PA', 'RI', 'SD', 'TX', 'UT', 'VT', 'VA', 'WA', 'WI');
		
	}*/
}
?>