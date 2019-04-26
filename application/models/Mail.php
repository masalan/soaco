<?php
class Item extends Base_Model
{
    protected $table_name;

    function __construct()
    {
        parent::__construct();
        $this->table_name = 'cd_inquiries';
    }





    /**
     * Fluid LOGS
     * @param bool $limit
     * @param bool $offset
     * @return mixed
     */
    function get_all_msg()
    {
        $this->db->from('cd_inquiries');
        $this->db->order_by('added','desc');
        return $this->db->get();
    }






}
?>