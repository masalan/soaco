<?php
class Review extends Base_Model
{
	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'cd_reviews';
	}

	function exists($data)
	{
		$this->db->from($this->table_name);
		
		if (isset($data['id'])) {
			$this->db->where('id',$data['id']);
		}
		
		if (isset($data['city_id'])) {
			$this->db->where('city_id', $data['city_id']);
		}
		
		$query = $this->db->get();
		return ($query->num_rows() >= 1);
	}

	function save(&$data, $id = false)
	{
		//if there is no data with this id, create new
		if (!$id && !$this->exists(array('id' => $id, 'city_id' => $data['city_id']))) {
			if ($this->db->insert($this->table_name, $data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			//else update the data
			$this->db->where('id', $id);
			return $this->db->update($this->table_name, $data);
		}
		
		return $false;
	}

	/**
	 * updates multiple data by multiple conditions
	 *
	 * @param      <type>  $data   The data
	 * @param      <type>  $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function update_by( $data, $conds )
	{
		$this->db->where( $conds );
		return $this->db->update( $this->table_name, $data );
	}

	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name, array('id' => $id));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

	function get_all($city_id, $limit=false, $offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		$this->db->where('status',1);
		
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		$this->db->order_by('added','desc');
		return $this->db->get();
	}

	function get_all_by_item_id($item_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('item_id',$item_id);
		$this->db->where('status',1);
		$this->db->order_by('added','desc');
		return $this->db->get();
	}

	function count_all($city_id = 0, $item_id=false)
	{
		$this->db->from($this->table_name);
		
		if($city_id != 0) {
			$this->db->where('city_id', $city_id);
		}
		
		if ($item_id) {
			$this->db->where('item_id',$item_id);
		}
		
		$this->db->where('status',1);
		return $this->db->count_all_results();
	}
	
	function count_all_by( $city_id, $conditions=array(), $limit=false, $offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset($conditions['searchterm'])) {
			$this->db->like('review',$conditions['searchterm']);
		}

		if ( isset( $conditions['item_id'] )) {
			$this->db->where('item_id', $conditions['item_id'] );
		}

		if ( isset( $conditions['appuser_id'] )) {
		// if the user id, filter by appuser_id
			$this->db->where( 'appuser_id', $conditions['appuser_id'] );
		}

		if ( isset( $conditions['is_appuser'] )) {
		// if is_appuser flag exists, filter by is_appuser
			$this->db->where( 'is_appuser', $conditions['is_appuser'] );
		}
			
		$this->db->where('status',1);
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		return $this->db->count_all_results();
	}

	function get_all_by_user( $conditions = array(), $limit = false, $offset = false, $is_count = false )
	{
		$this->db->from($this->table_name);

		if ( isset( $conditions['appuser_id'] )) {
		// if the user id, filter by appuser_id
			$this->db->where( 'appuser_id', $conditions['appuser_id'] );
		}

		if ( isset( $conditions['is_appuser'] )) {
		// if is_appuser flag exists, filter by is_appuser
			$this->db->where( 'is_appuser', $conditions['is_appuser'] );
		}
			
		$this->db->where('status',1);
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}

		if ( $is_count ) {
			return $this->db->count_all_results();
		}
		
		$this->db->order_by('added','desc');
		return $this->db->get();
	}
	
	function get_all_by($city_id, $conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset($conditions['searchterm'])) {
			$this->db->like('review',$conditions['searchterm']);
		}

		if ( isset( $conditions['item_id'] )) {
			$this->db->where('item_id', $conditions['item_id'] );
		}

		if ( isset( $conditions['appuser_id'] )) {
		// if the user id, filter by appuser_id
			$this->db->where( 'appuser_id', $conditions['appuser_id'] );
		}

		if ( isset( $conditions['is_appuser'] )) {
		// if is_appuser flag exists, filter by is_appuser
			$this->db->where( 'is_appuser', $conditions['is_appuser'] );
		}
			
		$this->db->where('status',1);
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
		$this->db->where('id',$id);
		return $this->db->update($this->table_name,array('status'=>0));
	}
	
	function delete_by_city($city_id)
	{
		$this->db->where('city_id', $city_id);
		return $this->db->delete($this->table_name);
	}
}
?>