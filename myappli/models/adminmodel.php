<?php
class Adminmodel extends CI_Model {

	function __construct()
    {
        parent::__construct();
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

	public function create_element()
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
			'type' => $this->input->post('type')
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
			'type' => $this->input->post('type')
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
		$query = $this->db->query('SELECT DISTINCT test_id FROM questions ORDER BY test_id ASC');
		$arr = array();
		foreach ($query->result() as $row)
		{
			$arr[$row->test_id] = $row->test_id; 
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
		for($i = 1; $i <= 5; $i++)
		{
			if($this->input->post('answer'.$i) === "")
				break;
			$to_append = html_escape($this->input->post('answer'.$i));
			$answers .= $to_append.",".$this->input->post('link'.$i).",".$this->input->post('tag'.$i)."|";  
		}
		$answers = substr($answers, 0, strlen($answers) - 1);
		
		$data = array(
			'test_id' => $this->input->post('test_id'),
			'type' => $this->input->post('type'),
			'cluster' => $this->input->post('cluster'),
			'question' => $this->input->post('question'),
			'seq' => $seq,
			'answers' => $answers
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
		for($i = 1; $i <= 5; $i++)
		{
			if($this->input->post('answer'.$i) === "")
				break;
			$to_append = html_escape($this->input->post('answer'.$i));
			$answers .= $to_append.",".$this->input->post('link'.$i).",".$this->input->post('tag'.$i)."|";  
		}
		$answers = substr($answers, 0, strlen($answers) - 1);
		
		$data = array(
			'test_id' => $this->input->post('test_id'),
			'type' => $this->input->post('type'),
			'cluster' => $this->input->post('cluster'),
			'question' => $this->input->post('question'),
			'seq' => $this->input->post('seq'),
			'answers' => $answers
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
		$this->db->query('DELETE FROM tags');
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
		$query = $this->db->query('SELECT id, votes, views FROM links');
		foreach ($query->result() as $row)
		{
			$new_views = $row->votes * 2 + rand(0,200);
			$this->db->query('UPDATE links SET views = '.$new_views.' WHERE id = '.$row->id);
		}
	}
}
?>