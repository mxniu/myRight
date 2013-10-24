<?php
class Adminmodel extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
	
	private function escape_html($input)
	{
		$input = str_replace(",", "&#44;", $input);
		$input = str_replace("'", "&#39;", $input);
		$input = str_replace('"', "&quot;", $input);
		$input = str_replace("§", "&sect;", $input);
		$input = str_replace("—", "&mdash;", $input);
		$input = str_replace("--", "&mdash;", $input);
		return $input;
	}
	
	public function get_category_data($id)
	{
		$this->db->cache_on();
		$this->db->select('slug');
		$this->db->where('id', $id);
	
		$query = $this->db->get('categories');
		$temp = $query->row();
		$this->db->cache_off();
		
        return $temp;
	}
	
	public function get_element($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
	
		$query = $this->db->get('links');
        return $query->row();
	}
	
	public function get_elements($category)
	{
		$this->db->select('id, title, votes');
		$this->db->where('category', $category);
		$this->db->order_by('votes desc');
	
		$query = $this->db->get('links');
        $categories_array = array();
		foreach ($query->result() as $row)
		{
			$categories_array[$row->id] = '['.$row->votes.']'.$row->title; 
		}
		return $categories_array;
	}
	
	public function get_posters()
	{
		$this->db->select('*');
		$this->db->order_by('name desc');
	
		$query = $this->db->get('posters');
        $posters_array = array();
		$posters_array[0] = '[NONE]';
		foreach ($query->result() as $row)
		{
			$posters_array[$row->id] = $row->name; 
		}
		return $posters_array;
	}

	public function create_element()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
		
		$date = new DateTime();
		$datestamp = $date->getTimestamp();
		
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'summary' => $this->input->post('summary'),
			'url' => $this->input->post('url'),
			'category' => $this->input->post('category'),
			'tags' => $this->input->post('tags'),
			'location' => $this->input->post('location'),
			'votes' => $this->input->post('votes'),
			'type' => $this->input->post('type'),
			'poster' => $this->input->post('poster'),
			'date_created' => $datestamp
		);
		
		return $this->db->insert('links', $data);
	}
	
	public function edit_element()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
		
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'summary' => $this->input->post('summary'),
			'url' => $this->input->post('url'),
			'category' => $this->input->post('category'),
			'tags' => $this->input->post('tags'),
			'location' => $this->input->post('location'),
			'votes' => $this->input->post('votes'),
			'type' => $this->input->post('type'),
			'poster' => $this->input->post('poster')
		);
		
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('links', $data);
	}
	
	public function delete_element()
	{
		$this->db->where('id', $this->input->post('id'));
		return $this->db->delete('links');
	}
	
	public function slug_script()
	{
		$this->db->cache_delete_all();
		$this->load->helper('url');
	
		$this->db->select('id, title');
	
		$query = $this->db->get('links');
		
        foreach ($query->result() as $row)
		{
			$slug = url_title($row->title, 'dash', TRUE);
			$sweep_test = $this->db->query('SELECT id FROM links WHERE slug = \''.$slug.'\'');
			if($sweep_test->num_rows() > 0)
			{
				$counter = 1;
				while($counter++)
				{	
					$test_slug = $slug.$counter;
					$sweep_test = $this->db->query('SELECT id FROM links WHERE slug = \''.$test_slug.'\'');
					if($sweep_test->num_rows() > 0)
						continue;
					else
					{
						echo $slug." changed to ".$test_slug;
						$slug = $test_slug;
						break;
					}
				}
			}
			
			$id = $row->id;
			$data = array(
               'slug' => $slug
            );

			$this->db->where('id', $id);
			$this->db->update('links', $data); 
		}
	}
	
	public function tag_slugs()
	{
		$this->db->cache_delete_all();
		$this->load->helper('url');
	
		$this->db->select('id, tagname');
	
		$query = $this->db->get('tags');
        foreach ($query->result() as $row)
		{
			$slug = url_title($row->tagname, 'dash', TRUE);
			$id = $row->id;
			$data = array(
               'slug' => $slug
            );

			$this->db->where('id', $id);
			$this->db->update('tags', $data); 
		}
	}
	
	public function get_categories()
	{
		$this->db->select('id, name');
	
		$query = $this->db->get('categories');
		$categories_array = array();
		foreach ($query->result() as $row)
		{
			$categories_array[$row->id] = $row->name; 
		}
		
        return $categories_array;
	}
	
	public function get_tags()
	{
		$query = $this->db->query('SELECT id, tagname FROM tags ORDER BY tagname ASC');
		$arr = array();
		foreach ($query->result() as $row)
		{
			$arr[$row->id] = $row->tagname; 
		}
		
		return $arr;
	}
	
	public function get_tag($tag_id)
	{
		$query = $this->db->query('SELECT * FROM tags WHERE id = '.$tag_id);
		
		return $query->row();
	}
	
	public function edit_tag()
	{
		$data = array(
			'test_id' => $this->input->post('test_id'),
			'description' => $this->input->post('description')
		);
		
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('tags', $data);
	}
	
	public function get_tests()
	{
		$query = $this->db->query('SELECT DISTINCT q.test_id, c.name FROM questions q LEFT JOIN categories c ON q.test_id = c.test_id ORDER BY test_id ASC');
		$arr = array();
		foreach ($query->result() as $row)
		{
			$arr[$row->test_id] = "[".$row->test_id."] ".$row->name; 
		}
		
		return $arr;
	}
	
	public function get_tests_by_version($version)
	{
		$query = $this->db->query('SELECT DISTINCT q.test_id, c.name FROM questions q LEFT JOIN categories c ON q.test_id = c.test_id WHERE c.version = '.$version.' ORDER BY test_id ASC');
		$arr = array();
		foreach ($query->result() as $row)
		{
			$arr[$row->test_id] = "[".$row->test_id."] ".$row->name; 
		}
		
		return $arr;
	}
	
	public function get_test($test_id)
	{
		$query = $this->db->query('SELECT id, seq, question FROM questions WHERE test_id = '.$test_id.' ORDER BY seq ASC');
		$arr = array();
		foreach ($query->result() as $row)
		{
			$arr[$row->id] = '['.$row->seq.'] '.$row->question; 
		}
		
		return $arr;
	}
	
	public function get_question($id)
	{
		$query = $this->db->query('SELECT * FROM questions WHERE id = '.$id);
		
		return $query->row();
	}
	
	public function create_test()
	{
		$test_id = 1;
		$query = $this->db->query('SELECT MAX(test_id) AS max FROM questions');
		if($query->num_rows() > 0)
			$test_id = (int) $query->row()->max + 1;
	
		$data = array(
			'test_id' => $test_id,
			'type' => 'MB',
			'question' => 'PLACEHOLDER',
			'seq' => 1,
			'answers' => 'TEST,,'
		);
		
		return $this->db->insert('questions', $data);
	}
	
	public function clone_test($test_id)
	{
		if($test_id <= 0)
			return false;
	
		$new_test_id = 1;
		$query = $this->db->query('SELECT MAX(test_id) AS max FROM questions');
		if($query->num_rows() > 0)
			$new_test_id = (int) $query->row()->max + 1;
	
		//Load the questions
		$query = $this->db->query("SELECT * FROM questions where test_id='".$test_id."' ORDER BY seq ASC");
				
		foreach ($query->result() as $row)
		{
			$data = array(
			'test_id' => $new_test_id,
			'type' => $row->type,
			'cluster' => $row->cluster,
			'question' => $row->question,
			'seq' => $row->seq,
			'answers' => $row->answers,
			'condition' => $row->condition
			);
			
			$this->db->insert('questions', $data);
		}
	}
	
	public function create_question()
	{
		//Calculate the seq, if necessary
		$seq = $this->input->post('seq');	
		if($seq == "0" || $seq == "")
		{
			$query = $this->db->query("SELECT MAX(seq) AS qcount FROM questions where test_id=".$this->input->post('test_id'));
			$seq = (int) $query->row()->qcount + 1;
		}
		
		//Construct the answer string
		$answers = '';
		for($i = 1; $i <= 10; $i++)
		{
			if($this->input->post('answer'.$i) === "")
				break;
			$to_append = $this->escape_html($this->input->post('answer'.$i));
			$answers .= $to_append.",".$this->input->post('link'.$i).",".$this->input->post('tag'.$i).",".$this->escape_html($this->input->post('var'.$i))."|";  
		}
		$answers = substr($answers, 0, strlen($answers) - 1);
		
		$data = array(
			'test_id' => $this->input->post('test_id'),
			'type' => $this->input->post('type'),
			'cluster' => $this->input->post('cluster'),
			'question' => $this->escape_html($this->input->post('question')),
			'seq' => $seq,
			'answers' => $answers,
			'condition' => $this->input->post('condition'),
			'explanation' => $this->input->post('explanation')
		);
		
		return $this->db->insert('questions', $data);
	}
	
	public function edit_question()
	{
		//Recalculate seqs if necessary
		if($this->input->post('seq') != 0 && $this->input->post('seq') != "")
		{ 
			$query = $this->db->query("SELECT id FROM questions where test_id=".$this->input->post('test_id')." AND seq=".$this->input->post('seq')." AND id<>".$this->input->post('id'));
			if($query->num_rows() > 0)
			{
				$query = $this->db->query("SELECT id FROM questions where test_id=".$this->input->post('test_id')." AND seq>=".$this->input->post('seq')." AND id<>".$this->input->post('id')." ORDER BY seq ASC");
				
				$new_seq = (int) $this->input->post('seq');
				foreach($query->result() as $row) {
					$new_seq++;
					$query2 = $this->db->query("UPDATE questions SET seq=".$new_seq." WHERE id=".$row->id);
				}
			}
		}
		
		//Construct the answer string
		$answers = '';
		for($i = 1; $i <= 10; $i++)
		{
			if($this->input->post('answer'.$i) === "")
				break;
			$to_append = $this->escape_html($this->input->post('answer'.$i));
			$answers .= $to_append.",".$this->input->post('link'.$i).",".$this->input->post('tag'.$i).",".$this->escape_html($this->input->post('var'.$i))."|";  
		}
		$answers = substr($answers, 0, strlen($answers) - 1);
		
		$data = array(
			'test_id' => $this->input->post('test_id'),
			'type' => $this->input->post('type'),
			'cluster' => $this->input->post('cluster'),
			'question' => $this->escape_html($this->input->post('question')),
			'seq' => $this->input->post('seq'),
			'answers' => $answers,
			'condition' => $this->input->post('condition'),
			'explanation' => $this->input->post('explanation')
		);
		$this->db->where('id', $this->input->post('id'));
		
		return $this->db->update('questions', $data);
	}
	
	public function delete_question()
	{
		$this->db->where('id', $this->input->post('id'));
		$this->db->delete('questions');
		
		//Recalculate seqs
		$query = $this->db->query("SELECT id FROM questions where test_id=".$this->input->post('test_id')." AND seq>=".$this->input->post('seq')." ORDER BY seq ASC");
		$new_seq = (int) $this->input->post('seq');
		
		foreach($query->result() as $row) {
			$query2 = $this->db->query("UPDATE questions SET seq=".$new_seq." WHERE id=".$row->id);
			$new_seq++;
		}
	}
	
	public function flush_cache()
	{
		$this->db->cache_delete_all();
	}
	
	public function build_tags()
	{
		$this->db->cache_delete_all();
		$this->db->query('DELETE FROM tagrel');
		$query = $this->db->query('SELECT id, tags FROM links');
		
		foreach ($query->result() as $row)
		{
			$tags = explode(",", $row->tags);
			foreach($tags as $tag)
			{
				//Check for whitespace
				if(ctype_space($tag) || $tag === '')
					continue;
					
				$match_tag = $this->db->query('SELECT id FROM tags where tagname=\''.html_escape(trim($tag)).'\'');
				echo 'SELECT id FROM tags where tagname=\''.html_escape(trim($tag)).'\'<br/>';
				$this_tid = 0;
				if ($match_tag->num_rows() > 0)
				{
					$tid = $match_tag->row();
					$this_tid = $tid->id;
				}
				else
				{
					echo 'INSERT INTO tags (`tagname`) VALUES (\''.html_escape(trim($tag)).'\')<br/>';
					$this->db->query('INSERT INTO tags (`tagname`) VALUES (\''.html_escape(trim($tag)).'\')');
					$this_tid = $this->db->insert_id();
				}
				if($this_tid != 0)
					$this->db->query('INSERT INTO tagrel (`lid`, `tid`) VALUES ('.$row->id.' ,'.$this_tid.')');
			}
		}
	}
	
	public function seed_views()
	{
		$query = $this->db->query('SELECT id FROM links');
		foreach ($query->result() as $row)
		{	
			$sub_query = $this->db->query('SELECT COUNT(id) as counter FROM views WHERE lid = '.$row->id);
			$this->db->query('UPDATE links SET views = '.$sub_query->row()->counter.' WHERE id = '.$row->id);
		}
	}
	
	public function seed_ratings()
	{
		$query = $this->db->query('SELECT * FROM links');
		foreach ($query->result() as $row)
		{	
			$this->db->query('UPDATE links SET votes = '.rand(5,15).' WHERE id = '.$row->id);
		}
		$query = $this->db->query('SELECT * FROM votes');
		foreach ($query->result() as $row)
		{	
			$sub_query = $this->db->query('SELECT votes FROM links WHERE id = '.$row->lid);
			$this->db->query('UPDATE links SET votes = '.((int) $sub_query->row()->votes + (int) $row->type * 2).' WHERE id = '.$row->lid);
		}
	}
	
	public function get_stats($test_id)
	{
		$bounce_counts = array();
	
		$results = array();
	
		$query = $this->db->query("SELECT COUNT(DISTINCT ip) AS total FROM track_entries WHERE test_id = $test_id");
		$results['total'] = $query->row()->total;
		
		$query = $this->db->query("SELECT ip, COUNT(*) as engagements FROM track_entries WHERE test_id = $test_id AND type = 'QLOAD' GROUP BY ip");
		$participatory_users = 0;
		$participatory_clicks = 0;
		$timediff = 0;
		$revisits = 0;
		$completes = 0;
		$skips = 0;
		foreach ($query->result() as $row)
		{
			if($row->engagements > 1)
			{
				$participatory_users++;
				$participatory_clicks += $row->engagements;
				
				$entries_query = $this->db->query("SELECT timestamp FROM track_entries WHERE test_id = $test_id AND type = 'BEGIN' AND ip = '".$row->ip."' ORDER BY timestamp ASC");
				if($entries_query->num_rows() > 1)
				{
					$entry_array = array();
					foreach($entries_query->result() as $entry_row)
					{
						$entry_array[] = $entry_row->timestamp;
					}
					for($i = 0; $i < count($entry_array); $i++)
					{
						if($i === count($entry_array) - 1)
							$sub_query = $this->db->query("SELECT MAX(timestamp) as closer FROM track_entries WHERE test_id = $test_id AND ip = '".$row->ip."'");
						else
							$sub_query = $this->db->query("SELECT MAX(timestamp) as closer FROM track_entries WHERE test_id = $test_id AND ip = '".$row->ip."' AND timestamp < '".$entry_array[$i+1]."'");
						$timediff += strtotime($sub_query->row()->closer) - strtotime($entry_array[$i]) + 10;
						//echo "".$row->ip." ".(strtotime($sub_query->row()->closer) - strtotime($entry_array[$i]))."<br/>";
						
						$third_query = $this->db->query("SELECT data FROM track_entries WHERE test_id = $test_id AND ip = '".$row->ip."' AND timestamp = '".$sub_query->row()->closer."' AND type = 'QLOAD'");
						
						if($third_query->num_rows() <= 0) continue;
						if(isset($bounce_counts[$third_query->row()->data]))
							$bounce_counts[$third_query->row()->data] = $bounce_counts[$third_query->row()->data] + 1;
						else
							$bounce_counts[$third_query->row()->data] = 1;
					}
				}
				else
				{
					$sub_query = $this->db->query("SELECT MIN(timestamp) as opener, MAX(timestamp) as closer FROM track_entries WHERE test_id = $test_id AND ip = '".$row->ip."'");
					$timediff += strtotime($sub_query->row()->closer) - strtotime($sub_query->row()->opener) + 10; 
					
					$third_query = $this->db->query("SELECT data FROM track_entries WHERE test_id = $test_id AND ip = '".$row->ip."' AND timestamp = '".$sub_query->row()->closer."' AND type = 'QLOAD'");
					
					if($third_query->num_rows() <= 0) continue;
					if(isset($bounce_counts[$third_query->row()->data]))
						$bounce_counts[$third_query->row()->data] = $bounce_counts[$third_query->row()->data] + 1;
					else
						$bounce_counts[$third_query->row()->data] = 1;
				}
				
				$sub_query = $this->db->query("SELECT count(*) as revisits FROM track_entries WHERE test_id = $test_id AND type = 'BEGIN' AND ip = '".$row->ip."'");
				
				$revisits += $sub_query->row()->revisits;
				
				$sub_query = $this->db->query("SELECT count(*) as completes FROM track_entries WHERE test_id = $test_id AND type = 'RLOAD' AND ip = '".$row->ip."'");
				
				if($sub_query->row()->completes > 0)
					$completes++;
				
				$sub_query = $this->db->query("SELECT count(*) as skips FROM track_entries WHERE test_id = $test_id AND type = 'RSKIP' AND ip = '".$row->ip."'");
				
				if($sub_query->row()->skips > 0)
					$skips++;
			}
		}
		$results['bounce_rate'] = round(((($results['total'] - $participatory_users)/$results['total']) * 100), 2);
		$results['engagement'] = round(($participatory_clicks/$participatory_users), 2);
		$results['time_spent'] = date("i:s", ($timediff/$participatory_users));
		$results['time_per_visit'] = date("i:s", ($timediff/$revisits));
		$results['revisits'] = round(($revisits/$participatory_users), 2);
		$results['pusers'] = $participatory_users;
		$results['completes'] = $completes-$skips;
		$results['bounce_counts'] = "";
		
		//Fix math operation captures
		foreach($bounce_counts as $key => $value)
		{
			$type = '';
			$curr_seq = 0;
			$q_query = $this->db->query("SELECT seq, type, test_id FROM questions WHERE id = ".$key);
			
			$type = $q_query->row()->type;
			$curr_seq = (int) $q_query->row()->seq;
			
			while($type === "MO")
			{
				$curr_seq += 1;
				
				$qq_query = $this->db->query("SELECT id, type FROM questions WHERE test_id = ".$q_query->row()->test_id." AND seq = ".$curr_seq);
				
				if($qq_query->row()->type === "MO")
				{
					continue;
				}
				
				if(isset($bounce_counts[$qq_query->row()->id]))
					$bounce_counts[$qq_query->row()->id] += $value;
				else
					$bounce_counts[$qq_query->row()->id] = $value;
				unset($bounce_counts[$key]);
				
				break;
			}
		}
		//Format output string
		foreach($bounce_counts as $key => $value)
		{
			$q_query = $this->db->query("SELECT seq, question FROM questions WHERE id = ".$key);
		
			$results['bounce_counts'] .= "[".$q_query->row()->seq."] ".strip_tags($q_query->row()->question).": <b>".$value."</b><br/>";
		}
		
		return $results;
	}
}
?>