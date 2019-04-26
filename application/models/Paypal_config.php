<?php

class Paypal_config extends Base_Model
{

	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'be_paypal_config';
	}

	function is_paypal_enable()
	{
		$query = $this->db->get_where( $this->table_name, array( 'status' => 1 ));
		return ( $query->num_rows() > 0 );
	}

	function save( $data )
	{
		return $this->db->update( $this->table_name, $data );
	}

	function get()
	{
		$query = $this->db->get_where( $this->table_name, array( 'status' => 1 ));
		return $query->row();
	}

	function get_paypal_config()
	{
		$query = $this->db->get_where( $this->table_name );
		return $query->row();
	}
}
?>