<?php
/**
 * Created by PhpStorm.
 * User: Alain Serge
 * Date: 06/03/2019
 * Time: 21:06
 */
class Stations extends Base_Model
{
    protected $table_name;

    function __construct()
    {
        parent::__construct();
        $this->table_name = 'cd_stations';
    }

    function exists($data)
    {
        $this->db->from($this->table_name);

        if (isset($data['id'])) {
            $this->db->where('id',$data['id']);
        }

        $query = $this->db->get();
        return ($query->num_rows()==1);
    }

    function get_all($limit=false, $offset=false)
    {
        $this->db->from($this->table_name);
        $this->db->where('is_approved', APPROVE );
        $this->db->where('status',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }

        return $this->db->get();
    }

    /**
     * Add Data
     * @param $data
     * @param bool $id
     * @return bool
     */
    function save(&$data, $id=false)
    {
        //if there is no data with this id, create new
        if (!$id && !$this->exists(array('id'=>$id))) {
            if ($this->db->insert($this->table_name,$data)) {
                $data['id'] = $this->db->insert_id();
                return true;
            }
        } else {
            //else update the data
            $this->db->where('id',$id);
            return $this->db->update($this->table_name,$data);
        }

        return false;
    }

    function get_all_by($conditions=array(), $limit=false, $offset=false)
    {
        $this->db->from($this->table_name);

        if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
            $this->db->where("(
				name LIKE '%". $this->db->escape_like_str($conditions['searchterm']) ."%' OR 
				description LIKE '%". $this->db->escape_like_str($conditions['searchterm']) ."%' OR
				address LIKE '%". $this->db->escape_like_str($conditions['searchterm']) ."%'
			)", NULL, FALSE);
        }

        if ( isset( $conditions['admin_id'] )) {
            $this->db->where( 'admin_id', $conditions['admin_id'] );
        }

        if ( isset( $conditions['is_approved'] )) {
            $this->db->where( 'is_approved', $conditions['is_approved'] );
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

    function count_all_by( $conditions=array(), $limit=false, $offset=false )
    {
        $this->db->from($this->table_name);

        if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
            $this->db->where("(
				name LIKE '%". $this->db->escape_like_str($conditions['searchterm']) ."%' OR 
				description LIKE '%". $this->db->escape_like_str($conditions['searchterm']) ."%' OR
				address LIKE '%". $this->db->escape_like_str($conditions['searchterm']) ."%'
			)", NULL, FALSE);
        }

        if ( isset( $conditions['admin_id'] )) {
            $this->db->where( 'admin_id', $conditions['admin_id'] );
        }

        if ( isset( $conditions['is_approved'] )) {
            $this->db->where( 'is_approved', $conditions['is_approved'] );
        }

        $this->db->where('status',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }

        return $this->db->count_all_results();
    }

    function get_info($id)
    {
        $query = $this->db->get_where($this->table_name, array('id'=>$id));

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }

    function get_current_city()
    {
        if ($this->session->userdata('city_id') != "") {
            return $this->get_info($this->session->userdata('city_id'));
        }
        return false;
    }

    function upload($city_id=0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }

        $upload_data = $this->uploader->upload($_FILES);

        if (!isset($upload_data['error'])) {
            foreach ($upload_data as $upload) {
                $image = array(
                    'parent_id'=> $city_id,
                    'type' => 'city',
                    'description' => htmlentites($this->input->post('image_desc')),
                    'path' => $upload['file_name'],
                    'width'=>$upload['image_width'],
                    'height'=>$upload['image_height']
                );
                $this->image->save($image);
            }
        } else {
            $data['error'] = $upload_data['error'];
        }

        $data['city'] = $this->city->get_info($city_id);

        $content['content'] = $this->load->view('stations/edit',$data,true);
        $this->load->view('template',$content);
    }

    function delete_by_city($city_id)
    {
        $this->db->where('id', $city_id);
        return $this->db->delete($this->table_name);
    }

    function search_by_geo($miles, $user_lat, $user_long)
    {
        $query = $this->db->query("SELECT *, ( 3959 * acos( cos( radians('".
            $this->db->escape($user_lat) ."') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$user_long') ) + sin( radians('".
            $this->db->escape($user_lat) ."') ) * sin( radians( lat ) ) ) ) AS distance FROM rt_cities HAVING distance < '".
            $this->db->escape($miles) ."' ORDER BY distance LIMIT 0 , 20");

        return $query;
    }

    function search_by_keyword($keyword)
    {
        $this->db->from($this->table_name);

        $this->db->where("(
						 keyword LIKE '%".$keyword."%' 
						 )", NULL, FALSE);

        $this->db->where('is_approved', APPROVE );
        $this->db->where('status',1);
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
}
?>