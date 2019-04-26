<?php
class User extends Base_Model
{
	protected $table_name;
	protected $module_table_name;
	protected $permission_table_name;
	protected $role_access_table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "be_users";
		$this->module_table_name = "be_modules";
		$this->permission_table_name = "be_permissions";
		$this->role_access_table_name = "be_role_access";
		$this->appuser_table_name = "cd_appusers";
	}

	/**
	 * exists return true if the user_id is already existed
	 * in the users table
	 *
	 * @param array user_data
	 * @return bool
	 */
	function exists($user_data)
	{
		$this->db->from($this->table_name);

		if (isset($user_data['user_id'])) {
			$this->db->where('user_id',$user_data['user_id']);
		}

		if (isset($user_data['user_name'])) {
			$this->db->where('user_name',$user_data['user_name']);
		}

		if (isset($user_data['user_email'])) {
			$this->db->where('user_email',$user_data['user_email']);
		}

        if (isset($user_data['phone'])) {
            $this->db->where('phone',$user_data['phone']);
        }

		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	/**
	 * Save function creates/updates the user data to users table.
	 * If the user_id is already exist in the users table,update user data
	 * else, the function will create new data row
	 *
	 * @param ref array $user_data
	 * @param int $user_id
	 * @return bool
	 */
	function save(&$user_data, $permission_data, $user_id=false)
	{
		$this->db->trans_start();
		$success = false;
		//if there is no data with this id, create new
		if (!$user_id && !$this->exists(array('user_id'=>$user_id))) {
			if ($this->db->insert($this->table_name,$user_data)) {
				$user_id = $this->db->insert_id();
				$user_data['user_id']= $user_id;
				$success = true;
			}
		} else {
			//else update the data
			$this->db->where('user_id',$user_id);
			$success = $this->db->update($this->table_name,$user_data);
		}

		//Insert permission
		if ($success) {
			//First lets clear out any permission the users currently has.
			$success = $this->db->delete($this->permission_table_name,array('user_id'=>$user_id));

			//Now insert the new permission
			if ($success) {
				foreach ($permission_data as $module) {
					$success = $this->db->insert($this->permission_table_name,
													array(
														'module_id'=>$module,
														'user_id'=>$user_id));
				}
			}
		}
		$this->db->trans_complete();
		return $success;
	}



    function save_like(&$data, $id = false)
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


    function save_company(&$user_data, $user_id=false)
    {
        $this->db->trans_start();
        $success = false;
        //if there is no data with this id, create new
        if (!$this->exists(array('user_id'=>$user_id))) {
      //   if (!$user_id && !$this->exists(array('user_id'=>$user_id))) {
            if ($this->db->insert($this->table_name,$user_data)) {
                $user_id = $this->db->insert_id();
                $user_data['user_id']= $user_id;
                $success = true;
            }
        } else {
            //else update the data
            $this->db->where('user_id',$user_id);
            $success = $this->db->update($this->table_name,$user_data);
        }

        $this->db->trans_complete();
        return $success;
    }



    function update_company(&$user_data, $user_id=false)
    {
        $this->db->trans_start();
        $success = false;
        //if there is no data with this id, create new
          if (!$user_id && !$this->exists(array('user_id'=>$user_id))) {

              $this->db->where('user_id',$user_id);
              $success = $this->db->update($this->table_name,$user_data);
        } else {
            //else update the data
            $this->db->where('user_id',$user_id);
            $success = $this->db->update($this->table_name,$user_data);
        }

        $this->db->trans_complete();
        return $success;
    }

	function update_profile($user_data, $user_id)
	{
		$this->db->where('user_id',$user_id);
		$success = $this->db->update($this->table_name,$user_data);
		return $success;
	}

	/**
	 * get_all function returns the array of user object
	 *
	 * @param int $limit
	 * @param int $offset
	 * @return user object array
	 */
	function get_all($limit=false, $offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('status',1);
        $this->db->where('is_gerant',0);
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


    function get_all_company($limit=false, $offset=false)
    {
        $this->db->from($this->table_name);
        //$this->db->where('status',1);
        $this->db->where('is_gerant',2);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by('user_id','desc');
        return $this->db->get();
    }

	/**
	 * get_info return the user object according to the user_id
	 *
	 * @param int user_id
	 * @return user object
	 */
	function get_info($user_id)
	{
		$query = $this->db->get_where($this->table_name,array('user_id'=>$user_id));

		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}


    /** GET Company Infos
     * @param $id
     * @return mixed
     */
    function get_company_info($user_id)
    {
        $query = $this->db->get_where($this->table_name,array('user_id'=>$user_id,'is_gerant'=>2));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }


    /** GET Company Infos
     * @param $id
     * @return mixed
     */
    /** GET Company Infos
     * @param $id
     * @return mixed
     */


    public function get_company_data($id)
    {$this->db->select('
    be_users.user_id,
    be_users.rccm,
    be_users.ifu,
    be_users.idus,
    be_users.fullname AS company_name,
    be_users.country_id,

    be_users.owner_name,
    be_users.cat_id,
    be_users.sub_cat_id,
    be_users.twon_id,
    be_users.address,
    be_users.lat,
    be_users.is_published,
    be_users.`status`,
    be_users.search_tag,
    be_users.contactes,
    be_users.company_phone,
    be_users.nosServices,
    be_users.lng,
    be_users.logo,
    be_users.profile_photo,
    be_users.about_me,
    be_users.is_city_admin,
    be_users.is_owner,
    be_users.role_id,
    be_users.user_pass,
    be_users.user_email,
    be_users.phone,
    be_users.answer,
    be_users.question,
    be_users.mother,
    be_users.father,
    be_users.user_name,
    be_users.company_id,
    be_users.is_gerant,
    be_users.arrondissement_id,
    be_users.city_id,
    be_users.station_id,
    cd_licence.is_live,
    cd_licence.licence_updated,
    cd_licence.licence_created,
    cd_licence.licence_end_time,
    cd_licence.licence_start_time,
    cd_licence.licence_name,
    cd_licence.licence_admin_id,
    cd_licence.licence_idus,
    cd_licence.licence_company_id');
        $this->db->from('be_users');
        $this->db->join('cd_licence ','be_users.user_id = cd_licence.licence_company_id','ON');
        if($id){
            $this->db->where(array('be_users.user_id'=>$id));
            $this->db->where('be_users.country_id',$this->session->userdata('country_id'));  // by country

        }else{
            $this->db->where(array('be_users.user_id'=>$id));
            $this->db->where('be_users.country_id',$this->session->userdata('country_id'));  // by country

        }
        return $this->db->get()->row();
    }



    function get_one_company_info($id)
    {
        $query = $this->db->get_where($this->table_name,array('user_id'=>$id,'is_gerant'=>2));
        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object($this->table_name);
        }
    }

	/**
	 * get_multiple_info function returns array of user object
	 * according to the user_id form user_id list
	 *
	 * @param array user_ids
	 * @return user object
	 */
	function get_multiple_info($user_ids)
	{
		$this->db->from($this->table_name);
		$this->db->where_in($user_ids);
		return $this->db->get();
	}

	/**
	 * get_info return the user object according to the user_id
	 *
	 * @param int user_id
	 * @return user object
	 */
	function get_info_by_email($email)
	{
		$query = $this->db->get_where($this->table_name,array('user_email'=>$email));

		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

	/**
	 * get_info return the user object according to the user_id
	 *
	 * @param int user_id
	 * @return user object
	 */
	function get_info_by_username( $user_name )
	{
		$this->db->from( $this->table_name );
		$this->db->where( 'user_name', $user_name );
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
		return $this->db->get();
	}

	/**
	 * Count all returns the total number of users in users table.
	 *
	 * @return int
	 */
	function count_all()
	{
		$this->db->from($this->table_name);
		$this->db->where('status',1);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        return $this->db->count_all_results();
	}


    function count_all_company()
    {
        $this->db->from($this->table_name);
        $this->db->where('status',1);
        $this->db->where('is_gerant',2);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        return $this->db->count_all_results();
    }
	function count_all_by($conditions=array())
	{
		$this->db->from($this->table_name);
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

		if (isset($conditions['searchterm'])) {
			$this->db->like('user_name',$conditions['searchterm']);
		}

		$this->db->where('status',1);
		return $this->db->count_all_results();
	}

	function get_all_by($conditions=array(), $limit=false, $offset=false)
	{
		$this->db->from($this->table_name);

		if (isset($conditions['searchterm'])) {
			$this->db->like('user_name',$conditions['searchterm']);
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

	/**
	 * Delete function update 1 to deleted fields from users table
	 * according to the user id
	 *
	 * @param int $user_id
	 * @return bool
	 */
	function delete($user_id)
	{
		$success = false;

		//Don't let user deleted their self
		if ($user_id==$this->get_logged_in_user_info()->user_id) {
			return false;
		}

		//Delete Permissions
		if ($this->db->delete($this->permission_table_name, array('user_id'=>$user_id))) {
			$this->db->where('user_id',$user_id);
			$success = $this->db->update($this->table_name,array('deleted'=>1));
		}

		$this->db->where('user_id',$user_id);

		$success = $this->db->update($this->table_name,array('status'=>0));

		return $success;
	}

    function delete_company($user_id)
    {
        $this->db->where('user_id',$user_id);
        $success = $this->db->update($this->table_name,array('status'=>0));
        return $success;
    }

	/**
	 * Delete list function update 1 to all fields from user table
	 * relating to the user ids of user_ids list
	 *
	 * @param array user_ids
	 * @return bool
	 */
	function delete_list($user_ids)
	{
		$success = false;

		//don't let employee delete their self
		if (in_array($this->get_logged_in_user_info()->user_id,$user_ids)) {
			return false;
		}

		//Delete Permissions
		$this->db->where_in('user_id',$user_ids);
		if ($this->db->delete($this->permission_table_name)) {
			//delete from user talbe
			$this->db->where_in('user_id',$user_ids);
			$success = $this->db->update($this->table_name,array('status'=>0));
		}
		return $success;
	}

	/**
	 * Login function check the user and set session.
	 *
	 * @param string user_name
	 * @param string user_password
	 * @return bool
	 */
	function login($user_email, $user_pass)
	{
		/* FIND USER IN SYSTEM USER TABLE */
		$is_frontend_user = false;

		$conds = array(
			'user_email' => $user_email,
			'user_pass' => md5( $user_pass ),
			'status' => 1
		);

		$query = $this->db->get_where( $this->table_name, $conds, 1 );

		/* IF NOT FOUND IN SYSTEM USER TABLE, FIND IN APP USER TABLE */
		if ( $query->num_rows() == 0 ) {

			/* FIND USER IN APP USER TABLE */
			$is_frontend_user = true;

			$conds = array(
				'email' => $user_email,
				'password' => md5( $user_pass ),
				'status' => 1
			);

			$query = $this->db->get_where( $this->appuser_table_name, $conds, 1 );

			/* IF NOT FOUND IN APP USER TABLE, RETURN FALSE */
			if ( $query->num_rows() == 0 ) {
				return false;
			}
		}
		$row = $query->row();
		/* SYSTEM USER AND CITY ADMIN INFORMATION */
		$user_id = ( $is_frontend_user )? $row->id: $row->user_id;
		$is_owner = ( $is_frontend_user )? 0: $row->is_owner;
		$role_id = ( $is_frontend_user )? 0: $row->role_id;
        $station_id = ($is_frontend_user )? 0: $row->station_id;   // Station ID
        $allow_city_id = 0;
		$is_city_admin = 0;

		/* CITY ADMIN INFORMATION */
		if ( !$is_frontend_user ) {
			if ( $row->is_city_admin ) {
				// get the city that user can manager
				$city_query = $this->db->get_where( 'cd_cities', array( 'admin_id' => $row->user_id ));

				$city_id = 0;

				if ( $city_query->num_rows() > 0 ) {
					$city = $city_query->row();
					$city_id = $city->id;
				}

				$allow_city_id = $city_id;
				$is_city_admin = true;
			}
		}

		/* SESSION VARIABLES */
		$this->session->set_userdata( 'user_id', $user_id );
		$this->session->set_userdata( 'is_owner', $is_owner );
		$this->session->set_userdata( 'role_id', $role_id );
		$this->session->set_userdata( 'allow_city_id', $allow_city_id );
		$this->session->set_userdata( 'is_city_admin', $is_city_admin );
		$this->session->set_userdata( 'station_id', $station_id);

        return true;
	}

	/**
	 * Log Out a user by destroying all session dta and redirect to login
	 *
	 */
	function logout()
	{
		//$this->session->sess_destroy();
		//redirect(site_url('login'));
		$this->session->unset_userdata( 'user_id' );
		$this->session->unset_userdata( 'is_owner' );
		$this->session->unset_userdata( 'role_id' );
		$this->session->unset_userdata( 'allow_city_id' );
		$this->session->unset_userdata( 'is_city_admin' );
		$this->session->unset_userdata( 'is_frontend_user' );

    }

	/**
	 * is_logged_in determines if a employee is logged in
	 */
	function is_logged_in()
	{
		return $this->session->userdata('user_id')!=false;
	}

	/**
	 * Gets information about the currently logged in user.
	 *
	 * @return bool
	 */
	function get_logged_in_user_info()
	{
		if ($this->is_logged_in()) {
		// if the user is already logged in

			// get session variables
			$user_id = $this->session->userdata('user_id');
			$is_frontend_user = $this->session->userdata( 'is_frontend_user' );

			$user;

			if ( $is_frontend_user ) {
			// if the user is front end user

				$query = $this->db->get_where( 'cd_appusers', array( 'id' => $user_id ));
				$user = $query->row();
			} else {
			// if the user is not front end user

				$user = $this->get_info( $user_id );
			}

			return $this->get_adapter_object( $user );
		}
		return false;
	}

	/**
	 * Has-permission determine whether the user has access for module
	 *
	 * @return bool
	 */
	function has_permission($module_id, $user_id)
	{
		$this->db->from($this->permission_table_name);
		$this->db->where('user_id',$user_id);
		$this->db->join($this->module_table_name,
			$this->module_table_name .".module_id = ". $this->permission_table_name .".module_id");
		$this->db->where($this->module_table_name .'.module_name', $module_id);
		$query = $this->db->get();

		return $query->num_rows() ==1;
	}

    /**
     * has_access determine whether the user has access for action
     */
    function has_access($action_id, $role_id)
    {
        //if action is null, allow access
        if ($action_id == null) {
            return true;
        }

        $this->db->from($this->role_access_table_name);
        $this->db->where('role_id',$role_id);
        $this->db->where('action_id',$action_id);
        $query = $this->db->get();

        return $query->num_rows() == 1;
    }

    function delete_by_city($city_id)
    {
        $this->db->where('city_id', $city_id);
        return $this->db->delete($this->table_name);
    }

    function is_system_user()
    {
        return ($this->session->userdata('role_id') != 4);
    }

    function is_station_user()
    {
        return ($this->session->userdata('role_id') != 5);
    }
    function is_station_user_two()
    {
        return ($this->session->userdata('role_id') != 6);
    }
    function is_frontend_user()
    {
        return ($this->session->userdata('is_frontend_user'));
    }


	/**
	 * combine App User and Sys User table structure and generate object
	 *
	 * @param      <type>    $user   The user
	 *
	 * @return     stdClass  The adapter object.
	 */
	function get_adapter_object( $user )
	{
		$obj = new stdClass();

		$obj->user_id = ( isset( $user->user_id ))? $user->user_id: $user->id;
		$obj->user_name = ( isset( $user->user_name ))? $user->user_name: $user->username;
		$obj->user_email = ( isset( $user->user_email ))? $user->user_email: $user->email;
		$obj->user_pass = ( isset( $user->user_pass ))? $user->user_pass: $user->password;
		$obj->is_banned = ( isset( $user->is_banned ))? $user->is_banned: 0;
		$obj->status = ( isset( $user->status ))? $user->status: 0;
		$obj->added = ( isset( $user->added ))? $user->added: 0;
		$obj->updated = ( isset( $user->updated ))? $user->updated: 0;
		$obj->role_id = ( isset( $user->role_id ))? $user->role_id: 0;
		$obj->is_owner = ( isset( $user->is_owner ))? $user->is_owner: 0;
		$obj->is_city_admin = ( isset( $user->is_city_admin ))? $user->is_city_admin: 0;
		$obj->about_me = ( isset( $user->about_me ))? $user->about_me: "";
		$obj->profile_photo = ( isset( $user->profile_photo ))? $user->profile_photo: "avatar.png";
		$obj->is_appuser = ( isset( $user->user_id ) )? 0: 1;

        //$obj->station_id = ( isset( $user->station_id ))? $user->station_id: $user->station_id;
        $obj->station_id = ( isset( $user->station_id ))? $user->station_id: 0;

		return $obj;
	}





    function log_action(&$log_data)
    {
        $query = $this->db->insert('log_action',$log_data);
            $user_id = $this->db->insert_id();
            $user_data['user_id']= $user_id;
        return $query;
    }


    /***
     * ADD and UPDATE Licence Company
     * @param $company_data
     * @param bool $company_id
     * @return bool
     */
    function company_licence(&$company_data, $company_id=false)
    {
        $this->db->trans_start();
        $success = false;
        //if there is no data with this id, create new
        if (!$this->exists_licence(array('company_id'=>$company_id))) {
            //   if (!$user_id && !$this->exists(array('user_id'=>$user_id))) {
            if ($this->db->insert('cd_licence',$company_data)) {
                $user_id = $this->db->insert_id();
                $user_data['user_id']= $user_id;
                $success = true;
            }
        } else {
            //else update the data
            $this->db->where('company_id',$company_id);
            $success = $this->db->update('cd_licence',$company_data);
        }

        $this->db->trans_complete();
        return $success;
    }


    function exists_licence($company_data)
    {
        $this->db->from('cd_licence');
        if (isset($user_data['company_id'])) {
            $this->db->where('company_id',$company_data['company_id']);
            $this->db->where('country_id',$this->session->userdata('country_id'));  // by country

        }
        $query = $this->db->get();
        return ($query->num_rows()==1);
    }



/*******************************SOCIETY*************************************/
    function count_all_societe($id = 0)
    {
        $this->db->from('cd_items');

        if($id != 0) {
            $this->db->where('company_id', $id);
        }
        $this->db->where('country_id',$this->session->userdata('country_id'));  // by country
        $this->db->where('is_published',1);
        return $this->db->count_all_results();
    }




    public function get_activity_sell($id)
    {$this->db->select('
    cd_fluid_log.station_id,
    cd_fluid_log.quantity_out,
    cd_fluid_log.time_out,
    cd_items.name AS station_name,
    cd_fluid_log.`status`,
    cd_fluid_log.is_oil,
    cd_fluid_log.is_consign,
    cd_fluid_log.new_bottle,
    cd_fluid_log.country_id');
        $this->db->from('cd_fluid_log');
        $this->db->join('cd_items ','cd_fluid_log.station_id = cd_items.id ','ON');
        $this->db->join('cd_countries ','cd_fluid_log.country_id = cd_countries.id','ON');

        if($id){
            $this->db->where(array('be_users.user_id'=>$id));
            $this->db->where('cd_fluid_log.country_id',$this->session->userdata('country_id'));  // by country

        }else{
            $this->db->where(array('be_users.user_id'=>$id));
            $this->db->where('be_users.country_id',$this->session->userdata('country_id'));  // by country

        }
        return $this->db->get()->row();
    }





    /*****


    SELECT
    cd_fluid_log.station_id,
    cd_fluid_log.quantity_out,
    cd_fluid_log.time_out,
    cd_items.`name`,
    cd_fluid_log.`status`,
    cd_fluid_log.is_oil,
    cd_fluid_log.is_consign,
    cd_fluid_log.new_bottle,
    cd_fluid_log.country_id
    FROM
    cd_fluid_log
    JOIN cd_items
    ON cd_fluid_log.station_id = cd_items.id
    JOIN cd_countries
    ON cd_fluid_log.country_id = cd_countries.id


     ******/





}
?>