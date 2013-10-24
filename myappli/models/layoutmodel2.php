<?php
class Layoutmodel2 extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

	public function get_elements($category)
	{
		//$this->db->cache_on();
		$this->db->select('*');
		$this->db->where('category', $category);
		$this->db->where('type !=', 'photo');
		$this->db->order_by('votes DESC, views DESC, title ASC');
	
		$query = $this->db->get('links');
		//$this->db->cache_off();
        return $query->result();
	}
	
	public function get_elements_rel($category, $rel)
	{
		$query = $this->db->query("SELECT * FROM links WHERE type != 'photo' AND (category = ".$category." OR category = ".$rel.") ORDER BY votes DESC, views DESC, title ASC");
		
        return $query->result();
	}
	
	public function get_rel_slug($rel)
	{
		$this->db->select('slug');
		$this->db->where('id', $rel);
	
		$query = $this->db->get('categories');
		$temp = $query->row();
		
        return $temp->slug;
	}
	
	public function get_elements_loc($category, $location)
	{
		//$this->db->cache_on();
		$query = $this->db->query('SELECT * FROM links WHERE category = \''.$category.'\' AND (location = \''.preg_replace( '/\-/', ' ', $location ).'\' OR location = \'\') AND type != \'photo\' ORDER BY votes DESC, views DESC, title ASC');
		//$this->db->cache_off();
		return $query->result();
	}
	
	public function get_tag_elements($category, $slug)
	{
		//$this->db->cache_on();
		$query = $this->db->query('SELECT l1.* FROM links l1 JOIN tagrel t2 on l1.id = t2.lid JOIN tags t1 on t2.tid = t1.id WHERE l1.category = \''.$category.'\' AND t1.slug = \''.$slug.'\' AND l1.type != \'photo\' ORDER BY l1.votes DESC, l1.views DESC, l1.title ASC');
        //$this->db->cache_off();
		return $query->result();
	}
	
	public function get_tag_loc_elements($category, $slug, $location)
	{
		//$this->db->cache_on();
		$query = $this->db->query('SELECT l1.* FROM links l1 JOIN tagrel t2 on l1.id = t2.lid JOIN tags t1 on t2.tid = t1.id WHERE l1.category = \''.$category.'\' AND t1.slug = \''.$slug.'\' AND (l1.location = \''.preg_replace( '/\-/', ' ', $location ).'\' OR l1.location = \'\') AND l1.type != \'photo\' ORDER BY l1.votes DESC, l1.views DESC, l1.title ASC');
        //$this->db->cache_off();
		return $query->result();
	}
	
	public function get_category_data($slug)
	{
		//$this->db->cache_on();
		$this->db->select('*');
		$this->db->where('slug', $slug);
	
		$query = $this->db->get('categories');
		$temp = $query->row();
		//$this->db->cache_off();
		
        return $temp;
	}
	
	public function get_tag_info($tagslug)
	{
		//$this->db->cache_on();
		$query = $this->db->query('SELECT id, tagname, description, test_id from tags where slug = \''.$tagslug.'\'');
		//$this->db->cache_off();
		
		return $query->row();
	}
	
	public function get_categories()
	{
		$this->db->select('slug');
	
		$query = $this->db->get('categories');
		$categories_array = array();
		foreach ($query->result() as $row)
		{
			$categories_array[] = $row->slug;
		}
		return $categories_array;
	}
	
	public function get_tags($category)
	{
		$this->db->cache_on();
		$query = $this->db->query('SELECT t1.tagname, t1.slug, count(distinct l1.id) as num_tag FROM tags t1 
									JOIN tagrel t2 ON t1.id = t2.tid
									JOIN links l1 ON t2.lid = l1.id 
									WHERE l1.category = '.$category.'
									GROUP BY t1.tagname
									ORDER BY num_tag DESC LIMIT 10');
		$this->db->cache_off();
		return $query->result();
	}
	
	public function get_related_tags($category, $slug)
	{
		$this->db->cache_on();
		$query = $this->db->query('SELECT t1.tagname, t1.slug, count(distinct t2.lid) as num_tag 
									FROM tags t1 
									JOIN tagrel t2 ON t1.id = t2.tid
									JOIN tagrel t3 ON t2.lid = t3.lid
									JOIN tags t4 ON t4.id = t3.tid
									JOIN links l1 ON t3.lid = l1.id 
									WHERE l1.category = '.$category.' AND t4.slug = \''.$slug.'\'
									GROUP BY t1.tagname
									ORDER BY num_tag DESC LIMIT 10');		
		return $query->result();
		$this->db->cache_off();
	}
	
	public function get_all_links()
	{
		$query = $this->db->query('SELECT count(id) AS link_count FROM links');
		return $query->row()->link_count;
	}
	
	public function get_locations($category)
	{
		$this->db->cache_on();
		$query = $this->db->query('SELECT DISTINCT location FROM links WHERE category = \''.$category.'\' AND location <> \'\'');
		$this->db->cache_off();
		return $query->result();
	}
	
	public function get_tag_locations($category, $id)
	{
		$this->db->cache_on();
		$query = $this->db->query('SELECT DISTINCT l1.location FROM links l1 JOIN tagrel t2 on l1.id = t2.lid JOIN tags t1 on t2.tid = t1.id WHERE category = \''.$category.'\' AND t1.id = '.$id.' AND location <> \'\'');
		$this->db->cache_off();
		return $query->result();
	}
	
	public function get_explans($test_id)
	{
		$query = $this->db->query('SELECT question FROM questions WHERE test_id = '.$test_id.' AND type = \'EX\'');
		$return_string = '';
		foreach ($query->result() as $row)
		{
			$return_string .= '<div>'.($row->question).'</div>';
		}
		return $return_string;
	}
}
?>