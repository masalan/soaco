<?php 
class Sub_Category extends Base_Model
{
	protected $table_name;
    protected $table_quartier;


    function __construct()
	{
		parent::__construct();
		$this->table_name = 'cd_sub_categories';
        $this->table_quartier = 'quartier';

    }


	function exists($data)
	{
		$this->db->from($this->table_name);
		
		if (isset($data['id'])) {
			$this->db->where('id',$data['id']);
		}
		
		if (isset($data['name'])) {
			$this->db->where('name',$data['name']);
		}
		
		if (isset($data['cat_id'])) {
			$this->db->where('cat_id', $data['cat_id']);
		}
		
		if (isset($data['city_id'])) {
			$this->db->where('city_id',$data['city_id']);
		}
		
		$query = $this->db->get();
		return ($query->num_rows() == 1);
	}

	function save(&$data, $id=false)
	{
		if (!$id && !$this->exists(array('id' => $id))) {
			if ($this->db->insert($this->table_name,$data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			$this->db->where('id',$id);
			return $this->db->update($this->table_name,$data);
		}		
		return false;
	}

	function get_all($city_id, $limit = false, $offset = false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by('cat_id','asc');
		return $this->db->get();
	}

    function get_all_company($id)
    {
        $this->db->from('be_users');
        $this->db->where('city_id', $id);
        $this->db->where('is_published',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->order_by('user_id','asc');
        return $this->db->get();
    }


	function get_sub_cat_name_by_id($id)
	{	
		$this->db->from($this->table_name);
		$this->db->where('id', $id);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
		    return $row->name;
		}
	}
	
	function get_only_publish($city_id, $limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		$this->db->where('is_published', 1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by('ordering','asc');
		return $this->db->get();
	}

	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name,array('id' => $id));
		
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

    function get_info_quartier($id)
    {
        $query = $this->db->get_where($this->table_quartier,array('id' => $id));

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_quartier);
        }
    }

	function get_multiple_info($ids)
	{
		$this->db->from($this->table_name);
		$this->db->where_in($ids);
		return $this->db->get();
	}

	function count_all($city_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		$this->db->where('is_published', 1);
		return $this->db->count_all_results();
	}

	function count_all_by($city_id, $conditions=array())
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset($conditions['searchterm'])) {
			$this->db->like('name', $conditions['searchterm']);
		}
			
		$this->db->where('is_published',1);
		return $this->db->count_all_results();
	}
	
	function get_all_by($city_id, $conditions=array(), $limit=false, $offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset($conditions['searchterm'])) {
			$this->db->like('name',$conditions['searchterm']);
		}

		if (isset($conditions['cat_id'])) {
			$this->db->where('cat_id',$conditions['cat_id']);
		}
			
		$this->db->where('is_published', 1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by('added','desc');
		return $this->db->get();
	}
	
	function get_all_by_cat($cat_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('cat_id', $cat_id);
		return $this->db->get();
	}

    /***
     *  Arrondissements
     * @param $cat_id
     * @param string $order_by
     * @param string $order_type
     * @param bool $limit
     * @param bool $offset
     * @return mixed
     */
	function get_all_by_cat_id($cat_id,$order_by='added',$order_type='desc',$limit=false,$offset=false) {
		$this->db->from($this->table_name);
		$this->db->where('cat_id', $cat_id);
		$this->db->where('is_published', 1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by($order_by,$order_type);
		
		return $this->db->get();
	}

    /**
     * Quartier
     * @param $cat_id
     * @param string $order_by
     * @param string $order_type
     * @param bool $limit
     * @param bool $offset
     * @return mixed
     */
    function get_all_quartier($cat_id,$order_by='id',$order_type='desc',$limit=false,$offset=false) {
        $this->db->from($this->table_quartier);
        $this->db->where('id_arrond', $cat_id);
        $this->db->where('is_published', 1);

        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }

        $this->db->order_by($order_by,$order_type);

        return $this->db->get();
    }









	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table_name);
 	}
 	
 	function delete_by_city($city_id)
 	{
 		$this->db->where('city_id', $city_id);
 		return $this->db->delete($this->table_name);
 	}
 	
 	function delete_by_cat($cat_id)
	{
		$this->db->where('cat_id', $cat_id);
		return $this->db->delete($this->table_name);
	}
}
?>