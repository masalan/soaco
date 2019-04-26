<?php 
class Fluid extends Base_Model
{
	protected $table_name;
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = ' cd_fluid';
	}
	
	function exists($data)
	{
		$this->db->from($this->table_name);
		
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
		}
		
		if (isset($data['sub_cat_id'])) {
			$this->db->where('sub_cat_id', $data['sub_cat_id']);
		}
		
		if (isset($data['name'])) {
			$this->db->where('name', $data['name']);
		}
		
		if (isset($data['city_id'])) {
			$this->db->where('city_id', $data['city_id']);
		}
		
		$query = $this->db->get();
		return ($query->num_rows() == 1);
	}


    /**  ADD
     * @param $data
     * @param bool $id
     * @return bool
     */
	function save(&$data, $id = false,$type = false)
	{
		if (!$id && !$this->exists(array('id' => $id, 'city_id' => $data['city_id']))) {
			if ($this->db->insert($this->table_name, $data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			$this->db->where('id', $id);
            $this->db->where('type', $type);
            return $this->db->update($this->table_name, $data);
		}	
		return false;
	}

    /***
     * Tableau Essence
     * @param $id
     * @return stdClass
     */
    function get_info_essence()
    {
        $query = $this->db->get_where($this->table_name,array('type'=>1));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }

    /***
     * Tableau Gasoil
     * @param $id
     * @return stdClass
     */
    function get_info_gasoil($id)
    {
        $query = $this->db->get_where($this->table_name,array('id'=>$id,'type'=> 2));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }

    /***
     * Tableau Kerosene
     * @param $id
     * @return stdClass
     */
    function get_info_kerosene($id)
    {
        $query = $this->db->get_where($this->table_name,array('id'=>$id,'type'=> 3));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }

    /***
     * Tableau Huile
     * @param $id
     * @return stdClass
     */
    function get_info_huile($id)
    {
        $query = $this->db->get_where($this->table_name,array('id'=>$id,'type'=> 4));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }

    function get_info($id,$type)
    {
        $query = $this->db->get_where($this->table_name,array('id'=>$id,'type'=>$type));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }


	function get_all($city_id=0, $limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		if ( $city_id != 0 )
			$this->db->where('city_id', $city_id);
		$this->db->where('is_published',1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by('added','desc');
		return $this->db->get();
	}
	
	function get_all_items($city_id, $limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
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
		$this->db->where('cat_id',$cat_id);
		return $this->db->get();
	}


    function get_station($cat_id)
    {
        $this->db->from($this->table_name);
        $this->db->where('city_id',$cat_id);
        $this->db->where('is_published',1);

        return $this->db->get();
    }
	
	function get_all_by_sub_cat($sub_cat_id, $keyword=false, $limit = false, $offset = false, $order_field = false, $order_type = false)
	{
		$this->db->from($this->table_name);

		if($order_field <> "like_count") {
			if($order_field && $order_type) {
				$this->db->order_by($order_field, $order_type);
			}
		}

		$this->db->where('sub_cat_id',$sub_cat_id);
		$this->db->where('is_published',1);
		
		
		if ($keyword && trim($keyword) != "") {
			$this->db->where("(
				name LIKE '%". $this->db->escape_like_str( $keyword ) ."%' OR 
				description LIKE '%". $this->db->escape_like_str( $keyword ) ."%' OR 
				search_tag LIKE '%". $this->db->escape_like_str( $keyword ) ."%' 
			)", NULL, FALSE);
		}
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}

		return $this->db->get();
	}
	
	function get_all_by_search($city_id = 0, $keyword = false, $limit = false, $offset = false)
	{
		$this->db->from($this->table_name);
		if($city_id != 0) {
			$this->db->where('city_id',$city_id);
		}
		$this->db->where('is_published',1);
		
		
		if ($keyword && trim($keyword) != "") {
			$this->db->where("(
				name LIKE '%". $this->db->escape_like_str( $keyword ) ."%' OR 
				description LIKE '%". $this->db->escape_like_str( $keyword ) ."%' OR 
				search_tag LIKE '%". $this->db->escape_like_str( $keyword ) ."%' 
			)", NULL, FALSE);
		}
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		return $this->db->get();
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
		//$this->db->where('is_published',1);
		return $this->db->count_all_results();
	}
	
	function count_all_by($city_id, $conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset( $conditions['sub_cat_id'] ) && $conditions['sub_cat_id'] != 0) {
			$this->db->where('sub_cat_id', $conditions['sub_cat_id']);
		}
		
		if (isset( $conditions['cat_id'] ) && $conditions['cat_id'] != 0) {
			$this->db->where('cat_id', $conditions['cat_id']);
		}
		
		if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
			$this->db->where("(
				name LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' OR 
				description LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' OR 
				search_tag LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' 
			)", NULL, FALSE);
		}
		
		$this->db->where('is_published',1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		return $this->db->count_all_results();
	}
	
	function get_all_by($city_id, $conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if ( isset( $conditions['sub_cat_id'] ) && $conditions['sub_cat_id'] != 0) {
			$this->db->where('sub_cat_id', $conditions['sub_cat_id']);
		}
		
		if ( isset( $conditions['cat_id'] ) && $conditions['cat_id'] != 0) {
			$this->db->where('cat_id', $conditions['cat_id']);
		}
		
		if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
			$this->db->where("(
				name LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' OR 
				description LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' OR 
				search_tag LIKE '%". $this->db->escape_like_str( $conditions['searchterm'] ) ."%' 
			)", NULL, FALSE);
		}
		
		$this->db->where('is_published',1);
		
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
		$this->db->where('id', $id);
		return $this->db->delete($this->table_name);
	}
	
	function delete_by_cat($cat_id)
	{
		$this->db->where('cat_id', $cat_id);
		return $this->db->delete($this->table_name);
	}
	
	function delete_by_sub_cat($sub_cat_id)
	{
		$this->db->where('sub_cat_id', $sub_cat_id);
		return $this->db->delete($this->table_name);
	}
	
	function get_popular_items($limit=false, $offset=false)
	{
		$filter = "";
		if ($limit && $offset) {
			$filter = "limit ". $this->db->escape( $limit ) ." offset ". $this->db->escape( $offset );
		} else if ($limit){
			$filter = "limit ". $this->db->escape( $limit ) ."";
		}
	
		$sql = "
			SELECT count( appuser_id ) as cnt, item_id
			FROM `rt_likes`
			GROUP BY item_id 
			Order By cnt desc
			$filter
		";
	
		$query = $this->db->query($sql);
		return $query;		
	}
	
	function delete_by_city($city_id)
	{
		$this->db->where('city_id', $city_id);
		return $this->db->delete($this->table_name);
	}
	
	function search_by_geo($miles, $user_lat, $user_long, $city_id, $sub_cat_id)
	{
		$query = $this->db->query("SELECT *, ( 3959 * acos( cos( radians(". 
			$this->db->escape( $user_lat ) .") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(". 
			$this->db->escape( $user_long ) .") ) + sin( radians(". 
			$this->db->escape( $user_lat ) .") ) * sin( radians( lat ) ) ) ) AS distance FROM cd_items Where city_id = ". 
			$this->db->escape( $city_id ) ." and sub_cat_id = ".
			$this->db->escape( $sub_cat_id ). "HAVING distance < ". 
			$this->db->escape( $miles ) ." ORDER BY distance LIMIT 0 , 20");
		
		return $query;
	}
}
?>