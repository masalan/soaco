<?php
class Inquiry extends Base_Model
{
	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'cd_inquiries';
	}

	function exists($data)
	{
		$this->db->from($this->table_name);
		
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
		}
		
		if (isset($data['city_id'])) {
			$this->db->where('city_id', $data['city_id']);
		}
		
		$query = $this->db->get();
		return ($query->num_rows() == 1);
	}

	function save(&$data, $id=false)
	{
		//if there is no data with this id, create new
		if (!$id && !$this->exists(array('id' => $id, 'city_id' => $data['city_id']))) {
			if ($this->db->insert($this->table_name, $data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			//else update the data
			$this->db->where('id',$id);
			return $this->db->update($this->table_name, $data);
		}
		
		return $false;
	}

	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name, array('id' => $id,'country_id'=>$this->session->userdata('country_id')));

        if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

	function get_all($city_id, $limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		$this->db->where('status', 1);
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

	function count_all($city_id = 0, $item_id=false)
	{
		$this->db->from($this->table_name);
		
		if($city_id != 0) {
			$this->db->where('city_id', $city_id);
		}
		
		if ($item_id) {
			$this->db->where('item_id',$item_id);
		}
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('status',1);
		return $this->db->count_all_results();
	}
	
	function count_all_by($city_id, $conditions=array())
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if (isset($conditions['searchterm'])) {
			$this->db->like('name',$conditions['searchterm']);
			$this->db->or_like('email',$conditions['searchterm']);
			$this->db->or_like('message',$conditions['searchterm']);
		}
			
		$this->db->where('status',1);
		return $this->db->count_all_results();
	}
	
	function get_all_by($city_id, $conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('city_id', $city_id);
		
		if (isset($conditions['searchterm'])) {
			$this->db->like('name',$conditions['searchterm']);
			$this->db->or_like('email',$conditions['searchterm']);
			$this->db->or_like('message',$conditions['searchterm']);
		}
			
		$this->db->where('status',1);
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
	
	function ago($time)
	{
		$time = mysql_to_unix($time);
		$now = mysql_to_unix($this->category->get_now());
		
	   $periods = array("seconde", "minute", "heure", "jour", "semaine", "mois", "année", "décennie");
	   $lengths = array("60","60","24","7","4.35","12","10");
	
	   $difference     = $now - $time;
	   $tense         = "ago";
	
	   for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	       $difference /= $lengths[$j];
	   }
	
	   $difference = round($difference);
	
	   if ($difference != 1) {
	       $periods[$j].= "s";
	   }
	   
	   if ($difference==0) {
	   		return "A peine";
	   } else {
	   		return "il y a $difference $periods[$j]";
	   }
	}


    function is_read(&$data, $id=false)
    {

        $this->db->where('id',$id);
        return $this->db->update('cd_inquiries', $data);
    }

    function count_all_msg_read($station_id)
    {
        $this->db->from('cd_inquiries');
        $this->db->where('station_id', $station_id);
        $this->db->where('is_read',1);
       $this->db->where('is_sending_by_station',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        return $this->db->count_all_results();
    }

    function count_all_msg_unread($station_id)
    {
        $this->db->from('cd_inquiries');
        $this->db->where('station_id', $station_id);
        $this->db->where('is_sending_by_station',1);
        $this->db->where('is_read',0);  // unread
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        return $this->db->count_all_results();
    }



    function get_all_msg_read($station_id=0, $limit=false,$offset=false)
    {
        $this->db->from('cd_inquiries');
        if ( $station_id != 0 )
            $this->db->where('station_id', $station_id);
          $this->db->where('is_read',0);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('id','desc');
        return $this->db->get();
    }

/*************************************** SOCIETE ******************************************************************/
    function get_all_msg_from_station($company_id=0, $limit=false,$offset=false)
    {
        $this->db->from('cd_inquiries');
        if ( $company_id != 0 )
            $this->db->where('company_id', $company_id);
      //  $this->db->where('is_read',0);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('is_read','asc');
      //  $this->db->order_by('id','desc');

        return $this->db->get();
    }


    function count_all_msg_unread_from_station($company_id = 0)
    {
        $this->db->from('cd_inquiries');

        if($company_id != 0) {
            $this->db->where('company_id', $company_id);
        }
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('is_read',0);
        return $this->db->count_all_results();
    }


    function get_all_msg_from_zone($company_id=0,$city_id=0, $limit=false,$offset=false)
    {
        $this->db->from('cd_inquiries');
        if($company_id != 0) {
            $this->db->where('company_id', $company_id);
        }
      //  $this->db->where('is_read',0);
        $this->db->where('city_id',$city_id);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('id','desc');
        //  $this->db->order_by('id','desc');

        return $this->db->get();
    }





}
?>