<?php
class Desk extends Base_Model
{
    protected $table_name;
    protected $table_fluid_log;
    protected $permission_table_name;
    protected $role_access_table_name;

    function __construct()
    {
        parent::__construct();
        $this->table_name = "be_users";
        $this->table_fluid_log = "cd_fluid_log";
        $this->permission_table_name = "be_permissions";
        $this->role_access_table_name = "be_role_access";
        $this->appuser_table_name = "cd_appusers";
    }





    /**
     * get_all function returns the array of user object
     *
     * @param int $limit
     * @param int $offset
     * @return user object array
     */
    function get_all_fluid_log($limit=false, $offset=false)
    {
        $this->db->from('cd_fluid_log');
        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }

        $this->db->order_by('id','desc');
        return $this->db->get();
    }






















}
?>