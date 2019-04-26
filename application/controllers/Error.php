<?php
class Error extends CI_Controller 
{

	// theme folder location
	protected $theme;

	// data object to pass to view
	protected $data;

	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );
		$this->theme = "templates/front-end/";
		$this->data['dir'] = $this->theme;
	}

	/**
	 * 404 Not Found
	 */
	function index()
	{
		$this->data['page_id'] = "error";
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'nav' );
		$this->load->view( $this->theme .'error' );
		$this->load->view( $this->theme .'footer' );
	}
}