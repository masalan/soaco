<?php
/**
 * Front End Home Page Controller
 * 
 */
include( APPPATH .'controllers/Main.php' );

class Home extends Main
{
	// theme folder location
	protected $theme;

	// data object to pass to view
	protected $data;

	// limit to show cities
	protected $limit;

	/**
	 * constrcuts for data initialization
	 * 
	 */
	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );
		$this->theme = "templates/front-end/";
		$this->limit = 8;

		$this->data['dir'] = $this->theme;
		$this->data['limit'] = $this->limit;
	}

	/**
	 * collects data and show on home page
	 * 
	 */
	function index()
	{
		/**
		 * Prepare Cities and About Us Data
		 */
		
		// get all cities data
		$cities = $this->city->get_all_by( array( 'is_approved' => 1 ), $this->limit )->result();
		if ( !empty( $cities )) {
			foreach ( $cities as &$city ) {
				$city->images = $this->image->get_all_by_type( $city->id, 'city' )->result();
			}

			$this->data['city_id'] = $cities[0]->id;
		}

		// set cities data
		$this->data['cities'] = $cities;
		
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

		/**
		 * Load views ( header + home + footer )
		 */
		$this->data['page_id'] = "home";

		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'home' );
		$this->load->view( $this->theme .'footer' );
	}

	/**
	 * Has more cities
	 *
	 * @param      <type>  $city_id  The city identifier
	 * @param      <type>  $item_id  The item identifier
	 * @param      <type>  $start    The start
	 */
	function has_more_cities( $start = 0 )
	{
		$conds = array( 'is_approved' => 1 );

		$count = $this->city->count_all_by( $conds, $this->limit, $start );

		if ( $count > 0 ) echo "true";
		else echo "false";
	}

	/**
	 * Loads more cities
	 *
	 * @param      <type>  $city_id  The city identifier
	 * @param      <type>  $item_id  The item identifier
	 * @param      <type>  $start    The start
	 */
	function load_more_cities( $start = 0 )
	{
		$conds = array( 'is_approved' => 1 );

		$cities = $this->city->get_all_by( $conds, $this->limit, $start )->result();
		if ( !empty( $cities )) {
			foreach ( $cities as &$city ) {
				$city->images = $this->image->get_all_by_type( $city->id, 'city' )->result();
			}
		}

		if ( count( $cities ) == 0 ) {
		// if no more data 
			
			echo "false";
		} else {
		// if have some data 
			
			$this->load->view( $this->theme .'cities', array( 'cities' => $cities ));
		}
	}
}