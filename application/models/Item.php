<?php 
class Item extends Base_Model
{
	protected $table_name;
    protected $table_fluid;
    protected $table_fluid_log;
    protected $cd_ravital_log;
    protected $table_be_users;

    private $temperature = 'temperature';
    private $site_log = 'site_log';



    function __construct()
	{
		parent::__construct();
		$this->table_name = 'cd_items';
        $this->table_fluid = 'cd_fluid';
        $this->table_fluid_log = 'cd_fluid_log';
        $this->cd_ravital_log = 'cd_ravital_log';
        $this->table_be_users = 'be_users';

        // be_users
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

	function save(&$data, $id = false)
	{
		if (!$id && !$this->exists(array('id' => $id, 'city_id' => $data['city_id']))) {
			if ($this->db->insert($this->table_name, $data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			$this->db->where('id', $id);
			return $this->db->update($this->table_name, $data);
		}	
		return false;
	}

	function get_all($city_id=0, $limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		if ( $city_id != 0 )
			$this->db->where('city_id', $city_id);
		$this->db->where('is_published',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country


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
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

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
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
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
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country


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
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

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

	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name,array('id'=>$id,'country_id'=>$this->session->userdata('country_id')));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

//$query = $this->db->get_where($this->table_fluid,array('type'=>$type,'station_id'=>$station_id,'country_id'=>$this->session->userdata('country_id')));


    function get_station_info($id)
    {
        $query = $this->db->get_where($this->table_name,array('id'=>$id,'country_id'=>$this->session->userdata('country_id')));

        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }

    //logo
    public function get_station_info_3($id)
    {
        $this->db->select('
    cd_items.id AS id,
    cd_items.id AS station_id,
    cd_items.cat_id,
    cd_items.sub_cat_id,
    cd_items.city_id,
    cd_items.twon_id,
    cd_items.company_id,
    cd_items.name AS station_name,
    cd_items.avatar,
    cd_items.description,
    cd_items.address,
    cd_items.phone,
    cd_items.email,
    cd_items.lat,
    cd_items.lng,
    cd_items.search_tag,
    cd_items.is_published,
    cd_items.added,
    cd_items.updated,
    be_users.logo AS logo,
    be_users.user_name,
    be_users.user_email AS gerant_email,
    be_users.fullname AS gerant_name,
    be_users.profile_photo AS gerant_avatar,
    be_users.user_id AS gerant_ID,
    be_users.owner_name,
    be_users.phone AS gerant_phone,
    be_users.nosServices,
    be_users.company_phone,
    be_users.address AS gerant_address');
        $this->db->from('cd_items');
        $this->db->join('be_users ','cd_items.id = be_users.station_id','ON');
        if($id){
            $this->db->where(array('cd_items.id'=>$id));
        }
        return $this->db->get()->row();
    }

	
	function get_multiple_info($ids)
	{
		$this->db->from($this->table_name);
		$this->db->where_in($ids);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        return $this->db->get();
	}
	
	function count_all($city_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		//$this->db->where('is_published',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        return $this->db->count_all_results();
	}
	
	function count_all_by($city_id, $conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

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
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

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


	/****************************STATION**********************************************/


    /***
     * Tableau Essence
     * @param $id
     * @return stdClass
     */
    function get_info_essence($country_id,$station_id)
    {
        $query = $this->db->get_where($this->table_fluid,array('type'=>1,'country_id'=>$country_id,'station_id'=>$station_id));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }

    /***
     * Tableau Gasoil
     * @param $id
     * @return stdClass
     */
    function get_info_gasoil($country_id,$station_id)
    {
        $query = $this->db->get_where($this->table_fluid,array('type'=>2,'country_id'=>$country_id,'station_id'=>$station_id));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }

    /***
     * Tableau Kerosene
     * @param $id
     * @return stdClass
     */
    function get_info_kerosene($country_id,$station_id)
    {
        $query = $this->db->get_where($this->table_fluid,array('type'=>3,'country_id'=>$country_id,'station_id'=>$station_id));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }

    /***
     * Tableau Huile
     * @param $id
     * @return stdClass
     */
    function get_info_huile($country_id,$station_id)
    {
        $query = $this->db->get_where($this->table_fluid,array('type'=>4,'country_id'=>$country_id,'station_id'=>$station_id));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }

    /***
     * Tableau Petrole
     * @param $id
     * @return stdClass
     */
    function get_infos_petrole($country_id,$station_id)
    {
        $query = $this->db->get_where($this->table_fluid,array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }

    /***
     * Tableau Gaz
     * @param $id
     * @return stdClass
     */
    function get_info_gaz($type,$station_id)
    {
       // $query = $this->db->get_where($this->table_fluid,array('type'=>6));
        $query = $this->db->get_where($this->table_fluid,array('type'=>$type,'station_id'=>$station_id,'country_id'=>$this->session->userdata('country_id')));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }


    /***
     * Tableau lubrifiants
     * @param $id
     * @return stdClass
     */
    function get_info_lubrifiants($type,$station_id)
    {
       // $query = $this->db->get_where($this->table_fluid,array('type'=>7));
        $query = $this->db->get_where($this->table_fluid,array('type'=>$type,'station_id'=>$station_id,'country_id'=>$this->session->userdata('country_id')));

        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }




    function get_info_stock($station_id,$type)
    {
        $query = $this->db->get_where($this->table_fluid,array('type'=>$type,'station_id'=>$station_id,'country_id'=>$this->session->userdata('country_id')));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_fluid);
        }
    }





    /**
     * Add buy Essence
     * @param $data
     * @return bool
     */
    function add_essence(&$data)
    {
        if ($this->db->insert($this->table_fluid_log, $data)) {
            return true;
        }
        return false;
    }

    function pay_fluid(&$data)
    {
        $quantity_in = $this->db->get_where($this->table_fluid,array('type'=>$data['type'],'station_id' => $data['station_id']))->row()->quantity_in;
        $quantity = $this->db->get_where($this->table_fluid,array('type'=>$data['type'],'station_id' => $data['station_id']))->row()->quantity;

        $this->db->where('station_id', $data['station_id']);
        $this->db->where('type', $data['type']);
        $this->db->set('quantity_in',$quantity_in+$data['quantity_in'], false);
        $this->db->set('quantity',$quantity-$data['quantity_in'], false);
        $update = $this->db->update($this->table_fluid);
        return $update ;
    }


    /***
     *  ADD STOCK
     * OK
     * @param $data
     * @param bool $station_id
     * @return bool
     */

    /***
    function ravitaillement(&$data, $station_id = false)
    {


      // if (!$this->exists_fluid(array('station_id' => $data['station_id'], 'type' => $data['type']))) {
      if (!$station_id && !$this->exists_fluid_ravit(array('station_id' => $data['station_id'], 'type' => $data['type']))) {
            $quantity = $this->db->get_where($this->table_fluid,array('type'=>$data['type'],'station_id' => $data['station_id']))->row()->quantity;
            $this->db->where('station_id', $data['station_id']);
            $this->db->where('type', $data['type']);
            $this->db->set('quantity',$quantity+$data['quantity'],'date_stock',false);
            $update = $this->db->update('cd_fluid');
            return $update ;
        } else {
          $query =  $this->db->insert('cd_fluid', $data);
          $data['id'] = $this->db->insert_id();
          return $query;
        }
        return true;
    }

     * ****/

    /**
     * Add mark
     * @param $data
     * @return bool
     */
    function add_mark(&$data)
    {
        if ($this->db->insert('cd_fuel_mark', $data)) {
            return true;
        }
        return false;
    }


    function add_mark_format(&$data)
    {
        if ($this->db->insert('cd_format_fuel', $data)) {
            return true;
        }
        return false;
    }

    /**
     * RAVITAILEMENT DE STOCK
     * @param $data
     * @return bool
     * OK
     */
    function ravitaillement($data){
        $this->db->trans_start();
        $success = false;

        $this->db->where('type', $data['type']);
        $this->db->where('station_id', $data['station_id']);
        $query = $this->db->get('cd_fluid');

        if ($query->num_rows() > 0){

            $quantity = $this->db->get_where($this->table_fluid,array('type'=>$data['type'],'station_id' => $data['station_id']))->row()->quantity;
            $this->db->where('station_id', $data['station_id']);
            $this->db->where('type', $data['type']);
            $this->db->set('quantity',$quantity+$data['quantity'],'date_stock',false);
            $success = $this->db->update('cd_fluid');

        }else{
            if ($this->db->insert('cd_fluid', $data)) {
                $data['id'] = $this->db->insert_id();
                $success = true;
            }
        }
        $this->db->trans_complete();
        return $success;
    }


    function sent_notes(&$data)
    {
        if ($this->db->insert('cd_inquiries', $data)) {
            return true;
        }
        return false;
    }

    /**
     * Historic de ravitaillement
     * @param $data
     * @return mixed
     */

    /**

    function ravitaillement_log($data)
    {
        $this->db->trans_start();
        $success = false;
        if ($this->db->insert('cd_ravital_log',$data)) {
            $success = true;
        }
        $this->db->trans_complete();
        return $success;
    }
    function ravitaillement($data){

    $this->db->where('type', $data['type']);
    $this->db->where('station_id', $data['station_id']);
    $query = $this->db->get('cd_fluid');

    if ($query->num_rows() > 0){

    $quantity = $this->db->get_where($this->table_fluid,array('type'=>$data['type'],'station_id' => $data['station_id']))->row()->quantity;
    $this->db->where('station_id', $data['station_id']);
    $this->db->where('type', $data['type']);
    $this->db->set('quantity',$quantity+$data['quantity'],'date_stock',false);
    $update = $this->db->update('cd_fluid');
    return $update ;

    }else{
    if ($this->db->insert('cd_fluid', $data)) {
    $data['id'] = $this->db->insert_id();
    return true;
    }
    }
    return false;
    }
     ***/


    function ravitaillement_log($data)
    {
       $query =  $this->db->insert('cd_ravital_log', $data);
        return $query;
    }


    function ravitaill_fuel_log($data)
    {
        $query =  $this->db->insert('cd_ravital_log', $data);
        return $query;
    }

    /**
     * Desk Page pay service
     * @param $data
     * @return mixed
     */
    function fluid_log(&$data)
    {
        $query =  $this->db->insert('cd_fluid_log', $data);
        return $query;
    }

    function get_recent_sell_oil_1($limit=false,$offset=false)
    {
        $this->db->from($this->table_fluid_log);
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('time_out','desc');
        return $this->db->get();
    }

    function get_recent_sell_oil($city_id=0, $limit=false,$offset=false)
    {
        $this->db->from($this->table_fluid_log);
        if ( $city_id != 0 )
            $this->db->where('station_id', $city_id);
        $this->db->where('status',1);

        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }

        $this->db->order_by('id','desc');
        return $this->db->get();
    }


    /**
     * EXIST FLUID
     *
     * @param $data
     * @return bool
     */
    function exists_fluid($data)
    {
        $this->db->from($this->table_fluid_log);

        if (isset($data['station_id'])) {
            $this->db->where('station_id', $data['station_id']);

        }
        if (isset($data['type'])) {
            $this->db->where('type', $data['type']);
        }


        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }


    /***
     * Check Ravitaillement
     * Station_ID exist
     *
     * @param $data
     * @return bool
     */

    function exists_fluid_ravit($data)
    {
        $this->db->from('cd_fluid');

        if (isset($data['station_id'])) {
            $this->db->where('station_id', $data['station_id']);

        }
        if (isset($data['type'])) {
            $this->db->where('type', $data['type']);
        }


        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }


    /***
     * Fluid LOGS
     * @param $station_id
     * @param bool $limit
     * @param bool $offset
     * @param string $order_field
     * @param string $order_type
     * @return mixed
     */
    function get_all_fluid_log($station_id, $limit=false, $offset=false, $order_field = 'time_out', $order_type = 'desc')
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->from('cd_fluid_log');
        $this->db->where('is_oil',0);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);
        $this->db->where('DATE(time_out)',$curr_date);//use date function

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
       // $this->db->order_by('time_out','desc');
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();
    }


    function get_secure_code($station_id, $limit=false, $offset=false, $order_field = 'id', $order_type = 'desc')
    {
        $this->db->from('cd_ravit_tempo');
       // $this->db->where('is_valid',0);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();
    }


    function count_all_code_valid($station_id = 0)
    {
        $this->db->from('cd_ravit_tempo');

        if($station_id != 0) {
            $this->db->where('station_id', $station_id);
        }
        $this->db->where('is_valid',0);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        return $this->db->count_all_results();
    }



    function count_all_code_invalid($station_id = 0)
    {
        $this->db->from('cd_ravit_tempo');

        if($station_id != 0) {
            $this->db->where('station_id', $station_id);
        }
        $this->db->where('is_valid',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        return $this->db->count_all_results();
    }


    /***
     *  vente d`huile journalier
     * @param $station_id
     * @param bool $limit
     * @param bool $offset
     * @param string $order_field
     * @param string $order_type
     * @return mixed
     */
  function get_all_fluid_log_oil($station_id, $limit=false, $offset=false, $order_field = 'time_out', $order_type = 'desc')
 {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->from('cd_fluid_log');
        $this->db->where('is_oil',1);

        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->where('DATE(time_out)',$curr_date);//use date function
        if ($offset) {
            $this->db->offset($offset);
        }

        $this->db->order_by($order_field,$order_type);
        return $this->db->get();
    }


    /**
     * Count By Type
     * @param $type
     * @return mixed
     */
    function count_all_fluid_log()
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->from('cd_fluid_log');
        $this->db->where('is_oil',0);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('DATE(time_out)',$curr_date);//use date function
        return $this->db->count_all_results();
    }


    function count_all_fluid_log_oil()
    {
        $this->db->from('cd_fluid_log');
        $this->db->where('is_oil',1);
        return $this->db->count_all_results();
    }


    function count_sell_fluid_log_1($type)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');


        $result =  $this->db->select('SUM(quantity_out)');
        $this->db->from('cd_fluid_log');
         $this->db->where('type',$type);
        $this->db->where('DATE(time_out)',$curr_date);
        return $result->get();
    }


    function count_sell_fluid_log($station_id,$type)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->select('SUM(quantity_out)');
        $this->db->from('cd_fluid_log');
        $this->db->where('type', $type);
        $this->db->where('station_id', $station_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        $this->db->where('DATE(time_out)',$curr_date);
        return $this->db->get();
    }


    function count_sell_fluid_log_2($type)
    {
        $now = date('Y-m-d '); //H:i:s

        $this->db->select_sum('quantity_out');
        $this->db->from('cd_fluid_log');
        $this->db->where('type', $type);
        $this->db->where('time_out',$now);
        return $this->db->get();
    }


    /** Vente Journalier
     * de chaque Produit
     * @param $type
     * @return mixed
     */

    function vente_par_jour($type,$station_id)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->select_sum('quantity_out');
        $this->db->where('type', $type);
        $this->db->where('status', 1);
        $this->db->where('is_oil',0);
        $this->db->where('DATE(time_out)',$curr_date);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id', $station_id);

        $query = $this->db->get('cd_fluid_log');
        return $query;
    }


    function vente_par_jour_1($type,$station_id)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->select_sum('quantity_out');
        $this->db->where('type', $type);
        $this->db->where('status', 1);
      //  $this->db->where('station_id', $station_id);
       // $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('is_oil',0);
        $this->db->where('DATE(time_out)',$curr_date);
        $query = $this->db->get('cd_fluid_log');
        return $query;
    }



    function creat_invoice(&$data)
    {
        if ($this->db->insert('cd_invoice', $data)) {
            $data['id'] = $this->db->insert_id();
            return true;
        }
    }



//get data from database


    function get_chart_essence(){
       // $this->db->select('quantity_out');
        $this->db->select('DATE_FORMAT(time_out, "%H:%i") AS time,quantity_out AS quantity');

        $this->db->order_by('id','asc');
        $this->db->limit('12');

        $this->db->where('type', 1);
        $result = $this->db->get('cd_fluid_log');
        return $result;
    }

    function get_chart_gasoil(){
        $this->db->select('quantity_out');
        $this->db->order_by('id','asc');
        $this->db->limit('12');

        $this->db->where('type', 2);
        $result = $this->db->get('cd_fluid_log');
        return $result;
    }

    function get_chart_petrole(){
        $this->db->select('quantity_out');
        $this->db->order_by('id','asc');
        $this->db->limit('12');

        $this->db->where('type', 5);
        $result = $this->db->get('cd_fluid_log');
        return $result;
    }


    function get_chart_date_ok(){
        $this->db->select(' DATE_FORMAT(time_out, "%H:%i") AS time');
        $this->db->limit('12');
        $this->db->order_by('id','asc');
        $result = $this->db->get('cd_fluid_log');
        return $result;
    }


    function get_chart_date(){
        $this->db->select('DATE_FORMAT(time_out, "%H:%i") AS time');
        $this->db->limit('12');
        $this->db->order_by('id','asc');
        $result = $this->db->get('cd_fluid_log');
        if ($result->num_rows() > 0) {
            $data = array();
            foreach ($result->result_array() as $key => $value) {
                $data[$key]['Temps'] = $value['time'];

            }


            }
        return $result;
    }

    function get_data(){
        $this->db->select('year,purchase,sale,profit');
        $result = $this->db->get('account');
        return $result;
    }
//quantity_out time_out type

    function get_data_log(){
        $this->db->select(' DATE_FORMAT(time_out, "%H:%i:%s") AS time,type,quantity_out');
       $query = $this->db->get('cd_fluid_log');
        $this->db->order_by('type','asc');
        $this->db->group_by('type');


        if ($query->num_rows() > 0) {
            $data = array();
            foreach ($query->result_array() as $key => $value) {


                $data[$key]['Quantite'] = $value['quantity_out'];
                $data[$key]['Temps'] = $value['time'];
               $data[$key]['Type'] = $value['type'];


//                1: essence 2 gasoil 3 kérosène 4 huile , 5 petrole , 6 gaz , 7 lubrifiants, 5kg=65 , 6kg=66, 12,5kg =g12 , 52kg =652

                /*****
                switch ($value['type']){
                    case '1':
                        echo $data[$key]['Essence'];
                        {
                            $essence = array();
                            foreach($value as $ky => $new)
                            {
                                $essence[$ky]['Quantite'] = $new['quantity_out'];
                                $essence[$ky]['Temps']    = $new['time'];
                                $essence[$ky]['Type']     = 'Essence';
                            }
                        }
                        break;
                    case '2':
                        echo $data[$key]['Gasoil'];
                        {
                            $gasoil = array();
                            foreach($value as $key2 => $new)
                            {
                                $gasoil[$key]['Quantite'] = $new['quantity_out'];
                                $gasoil[$key]['Temps']    = $new['time'];
                                $gasoil[$key]['Type']     = 'Gasoil';
                            }
                        }
                        break;
                    case '3':
                        echo $data[$key]['kérosène'];
                        break;
                    case '4':
                        echo $data[$key]['Huile'];
                        break;
                    case '5':
                        echo $data[$key]['Petrole'];
                        break;
                    case '6':
                        echo $data[$key]['Gaz'];
                        break;
                    case '7':
                        echo $data[$key]['lubrifiants'];
                        break;
                    case '65':
                        echo $data[$key]['5Kg'];
                    case '66':
                        echo $data[$key]['6Kg'];
                    case '612':
                        echo $data[$key]['12Kg'];
                    case '652':
                        echo $data[$key]['52Kg'];
                        break;
                    default : 'serge';
                }
                ****/
            }
           // return array($essence,$gasoil);
            return $data;

        }
        return NULL;
    }

    function get_chart_data_for_visits($start_date, $end_date) {
        $sql = 'SELECT SUM(no_of_visits) total_visits, DATE(access_date) day_date
     FROM ' . $this->site_log . '
     WHERE DATE(access_date) >= ' . $this->db->escape($start_date) . '
     AND DATE(access_date) <= ' . $this->db->escape($end_date) . '
     GROUP BY DATE(access_date) ORDER BY DATE(access_date) DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = array();
            foreach ($query->result_array() as $key => $value) {
                $data[$key]['label'] = $value['day_date'];
                $data[$key]['value'] = $value['total_visits'];
            }
            return $data;
        }
        return NULL;
    }



    function get_chart_data($start_date, $end_date) {
        $sql = 'SELECT * 
                FROM ' . $this->temperature . '
		WHERE DATE(temp_date)>=' . $this->db->escape($start_date) .
            ' AND DATE(temp_date)<=' . $this->db->escape($end_date);
        $query = $this->db->query($sql);
        $results = $query->result();
        return $results;
    }


    /******************************* BARRE CODE *************************************/

    // DECLARATION: CREATES BARCODE OF A PARTICULAR PRODUCT USING SERIAL NUMBER OF THE PRODUCT
    function create_barcode($serial_number)
    {
        // side effect: includes the font file for barcodes
        require_once('assets/barcode/class/BCGFontFile.php');

        // side effect: includes the color classes for barcodes
        require_once('assets/barcode/class/BCGColor.php');

        // side effect: includes the drawing classes for barcodes
        require_once('assets/barcode/class/BCGDrawing.php');

        // side effect: includes the barcode technology
        require_once('assets/barcode/class/BCGcode39.barcode.php');

        // Loading Font
        $font          = new BCGFontFile('assets/barcode/font/Arial.ttf', 18);
        // Don't forget to sanitize user inputs
        $text          = $serial_number;
        // The arguments are R, G, B for color.
        $color_black   = new BCGColor(0, 0, 0);
        $color_white   = new BCGColor(255, 255, 255);
        $drawException = null;
        try {
            $code = new BCGcode39();
            $code->setScale(2); // Resolution
            $code->setThickness(30); // Thickness
            $code->setForegroundColor($color_black); // Color of bars
            $code->setBackgroundColor($color_white); // Color of spaces
            $code->setFont($font); // Font (or 0)
            $code->parse($text); // Text
            $code->clearLabels();
        }
        catch (Exception $exception) {
            $drawException = $exception;
        }
        /* Here is the list of the arguments
        1 - Filename (empty : display on screen)
        2 - Background color */
        $drawing = new BCGDrawing('', $color_white);
        if ($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code);
            $drawing->draw();
        }
        // Header that says it is an image (remove it if you save the barcode to a file)
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="barcode.png"');
        // Draw (or save) the image into PNG format.
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }


    /**
     * Check existance
     * @param $id
     * @return stdClass
     */
    function get_info_exit($id)
    {
        $query = $this->db->get_where($this->table_be_users,array('user_id'=>$id));

        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_be_users);
        }
    }


    /** Check User
     * @param $data
     * @return bool
     */
    function check_exists($data)
    {
        $this->db->from($this->table_name);

        if (isset($data['user_id'])) {
            $this->db->where('user_id', $data['user_id']);
        }

        if (isset($data['phone'])) {
            $this->db->where('phone', $data['phone']);
        }

        if (isset($data['user_name'])) {
            $this->db->where('user_name', $data['user_name']);
        }

        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }


    function count_all_log($station_id,$type)
    {
        $this->db->from('cd_fluid_log');
        $this->db->where('station_id', $station_id);
        $this->db->where('type',$type);
        return $this->db->count_all_results();
    }


    function get_all_log($station_id, $limit=false,$offset=false)
    {
        $this->db->from('cd_fluid_log');
        $this->db->where('station_id', $station_id);
       //$this->db->where('type',1);

        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }

        $this->db->order_by('id','asc');
        return $this->db->get();
    }



    function count_all_jauge($station_id,$type)
    {
        $this->db->from('cd_jauge');
        $this->db->where('station_id', $station_id);
        $this->db->where('type',$type);
        return $this->db->count_all_results();
    }


    function get_all_jauge($station_id, $limit=false,$offset=false)
    {
        $this->db->from('cd_jauge');
        $this->db->where('station_id', $station_id);
        // $this->db->where('type',1);

        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }

       // $this->db->order_by('time_out','desc');
        return $this->db->get();
    }


    function jauge_to_update(&$data,$id)
    {
        $this->db->where('id', 1);
        return $this->db->update('cd_jauge', $data);
    }


    function count_all_ravit_log($station_id)
    {
        $this->db->from('cd_ravital_log');
        $this->db->where('station_id', $station_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }


    function get_all_ravit_log($station_id, $limit=false,$offset=false)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->where('DATE(date_stock)',$curr_date);
        $this->db->from('cd_ravital_log');
        $this->db->where('station_id', $station_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('id','asc');
        return $this->db->get();
    }




    function exists_invoice($data)
    {
        $this->db->from('cd_invoice');

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
        }

        if (isset($data['invoice_number'])) {
            $this->db->where('invoice_number', $data['invoice_number']);
        }

        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }



    function get_all_msg($is_read,$station_id)
    {
        $this->db->from('cd_inquiries');
        $this->db->where('is_sending_by_station', $is_read);  // 1 envoyer par la station
        $this->db->where('station_id', $station_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->order_by('added','desc');
        return $this->db->get();
    }




/*************************** COMPANY **********************************************/



    function get_historic_sell_company($company_id,$limit=false, $offset=false)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->from(cd_fluid_log);
        $this->db->where('company_id',$company_id);
        $this->db->where('status',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('DATE(time_out)',$curr_date);//use date function

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('1','desc');
        return $this->db->get();
    }

    /**
     * Fuel restant par produit
     * @param $type
     * @param $station_id
     * @return mixed
     */
    function all_fuel($type,$company_id)
    {
        $this->db->select_sum('quantity');
        $this->db->where('type', $type);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('company_id', $company_id);
        $query = $this->db->get('cd_fluid');
        return $query;
    }


    /***
     *  Fuel vendu today par produit
     * @param $type
     * @param $company_id
     * @return mixed
     */
    function fuel_sell_today($type,$company_id)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->select_sum('quantity_out');
        $this->db->where('type', $type);
       // $this->db->where('status', 1);
      //  $this->db->where('is_oil',0);
        $this->db->where('DATE(time_out)',$curr_date);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('company_id', $company_id);

        $query = $this->db->get('cd_fluid_log');
        return $query;
    }


    /**
     * Liste de Station
     * @param $city_id
     * @param bool $limit
     * @param bool $offset
     * @return mixed
     */
   // function list_station($city_id, $limit=false,$offset=false)
      function list_station($company_id)
       {
        $this->db->from('cd_items');
       $this->db->where('company_id', $company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

//        if ($limit) {
//            $this->db->limit($limit);
//        }
//
//        if ($offset) {
//            $this->db->offset($offset);
//        }

        $this->db->order_by('id','desc');
        return $this->db->get();
    }


    /**
     * Actif and desactif mail
     * @param $data
     * @param bool $id
     * @return bool
     */
    function save_action(&$data, $id=false)
    {
        //if there is no data with this id, create new
        if (!$id && !$this->exists_msg(array('id' => $id))) {
            if ($this->db->insert('cd_inquiries', $data)) {
                $data['id'] = $this->db->insert_id();
                return true;
            }
        } else {
            //else update the data
            $this->db->where('id',$id);
            return $this->db->update('cd_inquiries', $data);
        }

        return $false;
    }


    /**
     * vente du Jour
     * @param $station_id
     * @param bool $limit
     * @param bool $offset
     * @return mixed
     */
    function get_all_selling_today($company_id,$limit=false, $offset=false)
    {

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->from('cd_fluid_log');
        //$this->db->where('is_oil',0);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('company_id',$company_id);

        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->where('DATE(time_out)',$curr_date);//use date function
        if ($offset) {
            $this->db->offset($offset);
        }

        $this->db->order_by('time_out','desc');
        return $this->db->get();
    }




    function read(&$data, $id=false)
    {
        //else update the data
        $this->db->where('id',$id);
        return $this->db->update('cd_inquiries', $data);
    }

    function unread(&$data, $id=false)
    {
        //else update the data
        $this->db->where('id',$id);
        return $this->db->update('cd_inquiries', $data);
    }


    /** cobaye
     * @param $type
     * @param $company_id
     * @return mixed
     */
    function get_range_selling_1($type,$company_id)
    {

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');

        $start_date = '2019-04-2';
        $end_date = '2019-03-27';


        $this->db->select_sum('quantity_out');
        $this->db->where('type', $type);
      //  $this->db->where('time_out BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');

        $this->db->where('DATE(time_out)',$curr_date);//use date function


        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('company_id', $company_id);
       // $this->db->group_by('quantity_out');

        $query = $this->db->get('cd_fluid_log');
        return $query;
    }


    function get_range_selling($type,$company_id)
    {
        $start_date = '2019-04-02';
        $end_date = '2019-03-27';

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');

        $this->db->select_sum('quantity_out');
        $this->db->where('type', $type);
        $this->db->where('status', 1);
       // $this->db->where('is_oil',0);
        //$this->db->where('DATE(time_out)',$start_date);
        //$this->db->where('DATE(time_out)',$curr_date);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('company_id', $company_id);

        $query = $this->db->get('cd_fluid_log');
        return $query;
    }


    public function getUserTotalByWeek() {
        $date_start = strtotime('last Sunday');
        $week_start = date('Y-m-d', $date_start);
        $date_end = strtotime('next Sunday');
        $week_end = date('Y-m-d', $date_end);

        $user_data = array();

        $this->db->select('*, COUNT(*) AS quantity_out');
        $this->db->from('cd_fluid_log');
        $this->db->where('time_out >=', $week_start);
        $this->db->where('time_out <=', $week_end);
        $this->db->group_by('time_out');
        $query = $this->db->get();

        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', $date_start + ($i * 86400));
            $user_data[date('w', strtotime($date))] = array(
                'day'   => date('D', strtotime($date)),
                'total' => 0);
        }

        foreach ($query->result_array() as $result) {
            $user_data[date('w', strtotime($result['time_out']))] = array(
                'day'   => date('D', strtotime($result['time_out'])),
                'total' => $result['total']
            );
        }

        return $user_data;
    }







    function exists_msg($data)
    {
        $this->db->from('cd_inquiries');

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
        }

        if (isset($data['station_id'])) {
            $this->db->where('station_id', $data['station_id']);
        }

        if (isset($data['name'])) {
            $this->db->where('name', $data['name']);
        }

        if (isset($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }

        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }



    function get_all_station_ravit($company_id, $limit=false,$offset=false)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->where('DATE(date_stock)',$curr_date);
        $this->db->from('cd_ravital_log');
        $this->db->where('company_id', $company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('date_stock','asc');
        return $this->db->get();
    }


    function count_all_station_ravit($company_id)
    {
        $this->db->from('cd_ravital_log');
        $this->db->where('company_id', $company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }


    /**
     * By zone Station
     * @param $type
     * @param $company_id
     * @return mixed
     */
    function fuel_sell_by_zone_today($type,$dpt_id)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');
        $this->db->select_sum('quantity_out');
        $this->db->where('type', $type);
        // $this->db->where('status', 1);
        //  $this->db->where('is_oil',0);
        $this->db->where('DATE(time_out)',$curr_date);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('departement_id', $dpt_id);

        $query = $this->db->get('cd_fluid_log');
        return $query;
    }




    function search_data_station($search_data) {
        $this->db->select("cd_items.`name` AS name,
                           cd_items.avatar,
                            cd_items.cat_id,
                            cd_items.id,
                            cd_items.is_published,
                            cd_items.city_id AS zone,
                            cd_twon.`name` AS quartier,
                            cd_sub_categories.`name` AS sous_zone");
        $this->db->from('cd_items');
        $this->db->JOIN('cd_twon','ON cd_items.twon_id = cd_twon.twon_id');
        $this->db->JOIN('cd_sub_categories','ON cd_items.sub_cat_id = cd_sub_categories.id');

        $this->db->group_start();
        $this->db->like('cd_items.name', $search_data);
        $this->db->or_like('cd_twon.name', $search_data);
        $this->db->or_like('cd_items.name', $search_data);
        $this->db->group_end();
        $this->db->limit(15);
        $this->db->order_by("cd_items.id", 'desc');
        $query = $this->db->get();
        return $query->result();
    }


    function count_all_station_company($company_id,$city_id)
    {
        $this->db->from('cd_items');
        $this->db->where('is_published',1);
        $this->db->where('city_id',$city_id);
        $this->db->where('company_id',$company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }

    function count_all_gerant_company($company_id,$city_id)
    {
        $this->db->from('be_users');
        $this->db->where('is_gerant',1);
        $this->db->where('is_published',0);
        $this->db->where('city_id',$city_id);
        $this->db->where('company_id',$company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }


    function count_all_msg_company($company_id,$city_id)
    {
        $this->db->from('cd_inquiries');
        $this->db->where('is_sending_by_station',1);
        $this->db->where('is_read',0);    // 0 Non Lu
        $this->db->where('city_id',$city_id);
        $this->db->where('company_id',$company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }

    function list_station_by_zone($company_id,$city_id,$limit)
    {
        $this->db->from('cd_items');
        $this->db->where('company_id', $company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('city_id',$city_id);

        if ($limit) {
            $this->db->limit($limit);
        }

        $this->db->order_by('id','desc');
        return $this->db->get();
    }


    /**
     * Oil mark
     * @param $station_id
     * @return mixed
     */
    function count_all_mark_oils($station_id)
    {
        $this->db->from('cd_fuel_mark');
        $this->db->where('station_id',$station_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }


    /**
     * Oil mark
     * @param $station_id
     * @param bool $limit
     * @param bool $offset
     * @param string $order_field
     * @param string $order_type
     * @return mixed
     */
    function get_all_mark_oil($station_id, $limit=false, $offset=false, $order_field = 'added', $order_type = 'desc')
    {
        $this->db->from('cd_fuel_mark');
         $this->db->where('is_active',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();
    }



    function count_all_mark_format($station_id,$company_id)
    {
        $this->db->from('cd_format_fuel');
        $this->db->where('station_id',$station_id);
        $this->db->where('company_id',$company_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }

    function get_all_oil_format($station_id,$company_id, $limit=false, $offset=false, $order_field = 'added', $order_type = 'desc')
    {
        $this->db->from('cd_format_fuel');
       // $this->db->where('is_active',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);
        $this->db->where('company_id',$company_id);

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();
    }


    /**
     * Toutes les ventes d`essence
     * @param $station_id
     * @param $type
     * @return mixed
     */
    function count_all_essence_sell($station_id,$type,$is_consign = 0)
    {
        if ( $is_consign != 0 )
            $this->db->where('is_consign', $is_consign);

        $this->db->from('cd_fluid_log');
        $this->db->where('station_id', $station_id);
        $this->db->where('type', $type);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }


    /**
     * Liste de vente d`essence anterieur
     * @param $station_id
     * @param $type
     * @param bool $limit
     * @param bool $offset
     * @param string $order_field
     * @param string $order_type
     * @return mixed
     */
    function get_all_ess_log_oil($station_id,$type,$is_consign = 0, $limit=false, $offset=false, $order_field = 'id', $order_type = 'desc')
    {
        $this->db->from('cd_fluid_log');
        if ( $is_consign != 0 )
            $this->db->where('is_consign', $is_consign);

        $this->db->where('type', $type);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();
    }


    /**
     * Unpublish Oil
     * @param $id
     * @return mixed
     */
    function unpublish_format_oil($id)
    {
        $this->db->where('id',$id);
        $this->db->set('is_active',0, false);
        $update = $this->db->update('cd_format_fuel');
        return $update ;

    }

    /**
     * Publish Oil
     * @param $id
     * @return mixed
     */
    function publish_format_oil($id)
    {
        $this->db->where('id',$id);
        $this->db->set('is_active',1, false);
        $update = $this->db->update('cd_format_fuel');
        return $update ;

    }


    function delete_format_oil($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('cd_format_fuel');
    }




    function get_all_service_live_station($station_id,$company_id,$order_field = 'id', $order_type = 'asc')
    {
        $this->db->from('cd_sell_permission');
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);
        $this->db->where('company_id',$company_id);
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();

    }

    /**
     * Update Alert Fuel
     * @param $id
     * @param $data
     * @return mixed
     */
    function update_alert_fuel($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->where('station_id',$data['station_id']);
        $this->db->set('alert_limit',$data['alert_limit'], false);
        $update = $this->db->update('cd_sell_permission');
        return $update ;

    }

    function arret_service($id)
    {
        $this->db->where('id',$id);
        $this->db->set('is_active',0, false);
        $update = $this->db->update('cd_sell_permission');
        return $update ;

    }

    function actif_service($id)
    {
        $this->db->where('id',$id);
        $this->db->set('is_active',1, false);
        $update = $this->db->update('cd_sell_permission');
        return $update ;
    }

    function hidden_service($id)
    {
        $this->db->where('id',$id);
        $this->db->set('is_active',2, false);
        $update = $this->db->update('cd_sell_permission');
        return $update ;
    }



    function mark_oil_list($station_id,$order_field = 'id', $order_type = 'asc')
    {
        $this->db->from('cd_fuel_mark');
       // $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);

        $this->db->order_by($order_field,$order_type);
        return $this->db->get();
    }

    function get_list_service_live_station($station_id,$order_field = 'id', $order_type = 'asc')
    {
        $this->db->from('cd_sell_permission');
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('station_id',$station_id);
        $this->db->where('is_active',1);

        // $this->db->where('company_id',$company_id);
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();

    }

    function get_gaz($order_field = 'id', $order_type = 'asc')
    {
        $this->db->from('gaz_list');
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('is_active',1);

        // $this->db->where('company_id',$company_id);
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();

    }


    /**
     * Create Invoice
     * @param $data
     * @return mixed
     */
    function add_facture_creator(&$data)
    {
        $query =  $this->db->insert('cd_invoice', $data);
        $data['id'] = $this->db->insert_id();
        return $query;
    }


    /**
     * Invoice detais
     * @param $id
     * @return stdClass
     */
    function get_invoice($id,$station_id)
    {
        $query = $this->db->get_where('cd_invoice',array('id'=>$id,'station_id'=>$station_id,'country_id'=>$this->session->userdata('country_id')));

        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object('cd_invoice');
        }
    }


    /**
     * Gateway Service
     * @param string $order_field
     * @param string $order_type
     * @return mixed
     */
    function get_list_pay_service($order_field = 'id', $order_type = 'asc')
    {
        $this->db->from('type_pay');
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('status',1);
        $this->db->order_by($order_field,$order_type);
        return $this->db->get();

    }





    function pay_money_card(&$code,$cash,$moneyCardNow)
    {
        $rest_moeny = $this->db->get_where('cd_cards',array('card_serial'=>$code))->row()->rest_moeny;
       $initial_moeny = $this->db->get_where('cd_cards',array('card_serial'=>$code))->row()->initial_moeny;


       // $quantity = $this->db->get_where($this->table_fluid,array('type'=>$data['type'],'station_id' => $data['station_id']))->row()->quantity;

       // $this->db->where('station_id', $data['station_id']);
        $this->db->where('card_serial', $code);
        $this->db->set('rest_moeny',$rest_moeny+$cash, false);  // ok

        //$this->db->set('initial_moeny',$moneyCardNow, false);
        $update = $this->db->update('cd_cards');
        return $update ;
    }

















}
?>