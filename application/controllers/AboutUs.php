<?php
/**
 * Front End Item Filters Page Controller
 * 
 */
include_once( APPPATH .'controllers/Main.php' );

class AboutUs extends Main
{
	// theme folder name
	protected $theme;

	// data object to pass to view
	protected $data;

	/**
	 * Constrcuts required data
	 * 
	 */
	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );
		$this->theme = "templates/front-end/";
		$this->limit = 12;

		$this->data['dir'] = $this->theme;
		$this->data['page_id'] = 'about-us';
		$this->data['aboutus_cover'] = false;
	}

	/**
	 * About Us Main Function
	 */
	function index()
	{
		/* Get About Us Info */
		// get about us data
		$about = $this->about->get_all()->result();

		if ( !empty( $about )) {
			$this->data['about'] = $about[0];

			// get about us image
			$about_images = $this->image->get_all_by_type($about[0]->id, 'about')->result();

			if ( !empty( $about_images )) {
			// set about us image if exists
			
				$this->data['about_images'] = $about_images;
			} else {
			// set default about us image
				
				$this->data['about_images'][] = "/images/aboutus.jpg";
			}
		}

		/* Load views */
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'nav' );
		$this->load->view( $this->theme .'about-us' );
		$this->load->view( $this->theme .'footer' );

	}
}