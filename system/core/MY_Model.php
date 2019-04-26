<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    private $_table = NULL;

    public function __construct($table = NULL)
    {
        $this->_table = $table;
        parent::__construct();
        date_default_timezone_set('PRC');  // CHINA
    }

    /**
     * INSERTION une ligne
     * @param array $data
     * @return int insert_id
     */
    public function insert_one($data)
    {
        if(is_array($data) && !empty($data)){
            $result = $this->db->insert($this->_table, $data);
            if($result){
                return  $this->db->insert_id();
            }
        }
        return false;
    }

    /**
     * INSERT ALL
     * @param unknown $data
     */
    public function insert_all(array $data)
    {
        if($this->db->insert($this->_table, $data)){
            return  true;
        }
        return false;
    }

    /**
     * Mise a jour une ligne
     * @param int|string $key
     * @param array $value
     */
    public function update_one($where, array $value)
    {
        $this->db->where($where);
        $result = $this->db->update($this->_table, $value);
        return $result;
    }

    /**
     * GET ONE  Obtenir une ligne
     * @param unknown $key
     * @param unknown $value UP
     */
    public function get_one($name, $value, $Field = NULL)
    {
        $result = $this->db->select("$Field")->from($this->_table)->where($name,$value)->get()->row_array();
        return $result;
    }

    /**
     * GET ONE  Obtenir une ligne
     * @param unknown $key
     * @param unknown $value UP
     */
    // phone,email,username login
    public function multi_identity( $where = NULL, $Field = NULL)
    {
        if($Field==NULL){
            $Field = '*';
        }
        $this->db->where($where);
        $result = $this->db->select("$Field")->from($this->_table)->where($where)->get()->row_array();
        return $result;
    }




    public function login_identity($where = NULL, array $value, $Field = NULL)
    {
        if($Field==NULL){
            $Field = '*';
        }
        $this->db->where($where);
        $result = $this->db->select("$Field")->from($this->_table)->where($value)->get()->row_array();
        return $result;
    }




    public function login_id( $where, $Field = NULL)
    {
        $result = $this->db->select("$Field")->from($this->_table)->where($where)->get()->row_array();
        return $result;
    }


    /**
     * GET ALL
     * @param string $where Query conditions
     * @param string $field Get the specified field
     */
    public function get_all($where = NULL, $field = NULL, $order_by = NULL)
    {
        if($field==NULL){
            $field = '*';
        }
        $this->db->select($field)->from($this->_table);
        if($where){
            $this->db->where($where);
        }
        if($order_by){
            $this->db->order_by($order_by);
        }
        $result = $this->db->get()->result_array();
        return $result;
    }


    /**
     * DELETE
     */
    public function delete_one(array $where)
    {
        $result = false;
        if (!empty($where) && is_array($where)) {
            $result = $this->db->delete($this->_table, $where);
        }
        return $result;
    }


    /**
     * COUNT
     * @param array $where
     * @return int $result
     */
    public function count($where=NULL){
        $this->db->from($this->_table);
        if($where){
            $this->db->where($where);
        }
        $result = $this->db->count_all_results();
        return $result;
    }

}