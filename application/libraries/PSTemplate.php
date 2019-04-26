<?php
class PSTemplate
{
	protected $ci;
	protected $theme;

	function __construct( $params ) {
		$this->ci =& get_instance();
		$this->theme = $params['theme'];
	}

	function load( $template, $data = array(), $partials = array() ) 
	{
		if ( !empty( $partials )) {
			foreach ( $partials as $key => $partial ) {
				$view = $partial['view'];

				$d = array();
				if ( isset( $partial['data'] )) $d = $partial['data'];

				$data[$key] = $this->ci->load->view( $this->get_full_path( $view ), $d, true );
			}
		}

		$this->ci->load->view( $this->get_full_path( $template ), $data );
	}

	function get_full_path($view)
	{
		return "templates/{$this->theme}/{$view}";
	}
}