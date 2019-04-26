<?php
class Feed extends Base_Model
{
	protected $table_name;
    //protected $table_names;


    function __construct()
	{
		parent::__construct();
		$this->table_name = 'be_users'; //'cd_feeds';

    }

	function exists($data)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $data['city_id']);
		
		if (isset($data['id'])) {
			$this->db->where('user_id', $data['id']);
		}
		
		if (isset($data['city_id'])) {
			$this->db->where('city_id', $data['city_id']);
		}
		
		$query = $this->db->get();
		return ($query->num_rows() >= 1);
	}

	function save(&$data, $id=false)
	{
		if (!$id && !$this->exists(array('user_id' => $id, 'city_id' => $data['city_id']))) {
			if ($this->db->insert($this->table_name, $data)) {
				$data['user_id'] = $this->db->insert_id();
				return true;
			}
		} else {
			$this->db->where('user_id', $id);
			return $this->db->update($this->table_name, $data);
		}	
		return false;
	}


    function update(&$data, $id=false)
    {
        $this->db->where('user_id', $id);
        return $this->db->update($this->table_name, $data);
    }


	function get_all($city_id, $limit=false, $offset=false, $order_field = 'added', $order_type = 'desc')
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
        $this->db->where('is_gerant', 1);

        if ($limit) {
			$this->db->limit($limit);
		}
		if ($offset) {
			$this->db->offset($offset);
		}
		$this->db->order_by($order_field,$order_type);
		return $this->db->get();
	}
	
	function get_all_published($city_id, $limit=false, $offset=false, $order_field = 'added', $order_type = 'desc')
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		$this->db->where('status', 1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by($order_field,$order_type);
		return $this->db->get();
	}

	function count_all_published($city_id, $limit=false, $offset=false, $order_field = 'added', $order_type = 'desc')
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		$this->db->where('status', 1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by($order_field,$order_type);
		return $this->db->count_all_results();
	}

	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name, array('user_id' => $id,'is_gerant' => 1));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

	function get_multiple_info($ids)
	{
		$this->db->from($this->table_name);
		$this->db->where_in($ids);
		return $this->db->get();
	}

    /**
     * @param $city_id
     * @return mixed
     */
	function count_all($city_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
        $this->db->where('is_gerant', 1);
        return $this->db->count_all_results();
	}
	
	function count_all_by($city_id, $conditions=array())
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
			$this->db->where("(
				user_name LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' OR 
				fullname LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%'
			)", NULL, FALSE);
		}
		return $this->db->count_all_results();
	}
	
	function get_all_by($city_id, $conditions=array(), $limit=false, $offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
			$this->db->where("(
				user_name LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' OR 
				fullname LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%'
			 )", NULL, FALSE);
		}
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by('added','desc');
		return $this->db->get();
	}

	function delete($id)
	{
		$this->db->where('user_id',$id);
		return $this->db->delete($this->table_name);
	}
	
	function delete_by_city($city_id)
	{
		$this->db->where('city_id', $city_id);
		return $this->db->delete($this->table_name);
	}
	
	function read_more_text($string)
	{
		$string = strip_tags($string);
		
		if (strlen($string) > 100) {
		
		    // truncate string
		    $stringCut = substr($string, 0, 100);
		
		    // make sure it ends in a word so assassinate doesn't become ass...
		    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
		}
		return $string;
	}
}




/***************************************  COMMUNE  **************************************************/
function count_all_com($city_id)
{
    $this->db->from('cd_commune');
    $this->db->where('city_id', $city_id);
    return $this->db->count_all_results();
}


function get_all_com($city_id, $limit=false, $offset=false, $order_field = 'added', $order_type = 'desc')
{
    $this->db->from('cd_commune');
    $this->db->where('city_id', $city_id);

    if ($limit) {
        $this->db->limit($limit);
    }

    if ($offset) {
        $this->db->offset($offset);
    }

    $this->db->order_by($order_field,$order_type);
    return $this->db->get();
}

?>