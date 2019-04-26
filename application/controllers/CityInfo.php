l<?php
/**
 * Front End Item Filters Page Controller
 * 
 */
include_once( APPPATH .'controllers/Main.php' );

class CityInfo extends Main
{
	// theme folder name
	protected $theme;

	// data object to pass to view
	protected $data;

	// item count limit to show on first page
	protected $limit;

	/**
	 * Constrcuts required data
	 * 
	 */
	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );
		$this->theme = "templates/front-end/";
		$this->limit = 9;

		$this->data['dir'] = $this->theme;
		$this->data['limit'] = $this->limit;
		$this->data['page_id'] = 'city';
	}

	/**
	 * pepare required data to show on item filter page
	 *
	 * @param      boolean  $city_id  current_city_id
	 */
	function index( $city_id = false )
	{
		$conds = array();

		if ( $this->input->server('REQUEST_METHOD') == 'POST') {
		// if the method is 'POST', the search data is from home page

			if ( isset( $_POST['city'] ) && !empty( $_POST['city'])) {
			// if 'city' keyword is existed in search,

				$city_id = $this->input->post('city');
			}

			if ( isset( $_POST['cat'] )) {
			// if 'category id' is existed,
				
				$conds['cat_id'] = $this->input->post('cat');
				$this->data['cat_id'] = $conds['cat_id'];
			}

			if ( isset( $_POST['sub_cat'] )) {
			// if 'sub category id' is existed,

				$conds['sub_cat_id'] = $this->input->post('sub_cat');
				$this->data['sub_cat_id'] = $conds['sub_cat_id'];
			}

			if ( isset( $_POST['searchterm'] )) {
			// if 'search term' is existed,

				$conds['searchterm'] = $this->input->post('searchterm');
				$this->data['searchterm'] = $conds['searchterm'];
			}

		}

		// city dropdown
		$cities = $this->city->get_all()->result();

		if ( !empty( $cities )) {
			foreach ( $cities as $c ) {
				$c->images = $this->image->get_all_by_type( $c->id, 'city')->result();
			}
		}

		if ( $city_id == 0 ) {
		// if city id is zero, get the first city
			$city_id = $cities[0]->id;
		}
		
		// city data
		$city = $this->city->get_info( $city_id );
		
		$city->images = $this->image->get_all_by_type( $city_id, 'city')->result();
		$city->categories = $this->get_categories( $city_id, false );
		$city->sub_categories = $this->get_sub_categories( $city_id, 0, false );

		// items list
		$items = $this->get_all_items( $city_id, 0, $conds );
		
		// prepare data
		$this->data['cities'] = $cities;
		$this->data['city'] = $city;
		$this->data['items'] = $items;
		// $this->data['categories'] = array();
		// $this->data['sub_categories'] = array();
		
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'city' );
		$this->load->view( $this->theme .'footer' );
	}

	/**
	 * gets items array by limit and offset
	 *
	 * @param      <type>   $city_id  The city identifier
	 * @param      integer  $start    The start
	 * @param      array    $data     The data
	 *
	 * @return     <type>   All items.
	 */
	function get_all_items( $city_id, $start = 0, $data = array()) 
	{
		// get all items by city id
		$items = $this->item->get_all_by( $city_id, $data, $this->limit, $start )->result();

		// get item detail information
		$this->get_item_info( $city_id, $items );

		return $items;
	}

	/**
	 * get item detail information
	 *
	 * @param      <int>  $city_id  current city id
	 * @param      <array>  $items    items array
	 */
	function get_item_info ( $city_id, &$items ) 
	{
		if ( !empty( $items )) {
			foreach ( $items as &$item ) {

				// get item images
				$item->images = $this->image->get_all_by_type( $item->id, 'item' )->result();

				// get like count
				$item->like_count = $this->like->count_all( $city_id, $item->id );

				// get review count
				$item->review_count = $this->review->count_all( $city_id, $item->id );

				// get favourite count
				$item->fav_count = $this->favourite->count_all( $city_id, $item->id );
			}
		}
	}

	/**
	 * check more items list
	 *
	 * @param      <int>   $city_id  city id
	 * @param      integer  $start    offset
	 */
	function has_more_items( $city_id, $start = 0, $cat_id = 0, $sub_cat_id = 0, $searchterm = false )
	{
		// prepare filters
		$conds = array();
		if ( $cat_id != 0 ) {
			$conds['cat_id'] = $cat_id;
		} 

		if ( $sub_cat_id != 0 ) {
			$conds['sub_cat_id'] = $sub_cat_id;
		}

		if ( $searchterm != false ) {
			$conds['searchterm'] = $searchterm;
		}

		// get all items with detail information
		$count = $this->item->count_all_by( $city_id, $conds, $this->limit, $start );

		if ( $count > 0 ) echo "true";
		else echo "false";
	}

	/**
	 * provide item list view with requested data via Ajax
	 *
	 * @param      <int>   $city_id  city id
	 * @param      integer  $start    offset
	 */
	function load_more_items( $city_id, $start = 0, $cat_id = 0, $sub_cat_id = 0, $searchterm = false )
	{
		// prepare filters
		$conds = array();
		if ( $cat_id != 0 ) {
			$conds['cat_id'] = $cat_id;
		} 

		if ( $sub_cat_id != 0 ) {
			$conds['sub_cat_id'] = $sub_cat_id;
		}

		if ( $searchterm != false ) {
			$conds['searchterm'] = $searchterm;
		}

		// get all items with detail information
		$items = $this->get_all_items( $city_id, $start, $conds );

		// load item list view with data and return via Ajax
		$this->load->view( $this->theme .'item-list', array( 'items' => $items ) );
	}

	/**
	 * Return the categories by city id, returns view if $view variable is true
	 *
	 * @param      <type>   $city_id  The city identifier
	 * @param      boolean  $view     The view
	 *
	 * @return     <type>   The categories.
	 */
	function get_categories( $city_id, $view = true )
	{
		$cats = $this->category->get_all_by( $city_id )->result();

		if ( !$view ) {
			return $cats;
		}

		$this->show_dropdown( $cats, 'All Categories', 'cat-select' );
	}

	/**
	 * Get Categories JSON
	 *
	 * @param      <type>  $city_id  The city identifier
	 */
	function ajx_get_cats( $city_id )
	{
		$cat = $this->category->get_empty_object('cd_categories');
		$cat->id = 0;
		$cat->name = "All Categories";
		$cats[0] = $cat;

		$cats = array_merge( $cats, $this->get_categories( $city_id, false ));

		echo json_encode( $cats );
	}

	/**
	 * Return the sub categories by city id and (cat id),
	 * returns view if $view variable is true
	 *
	 * @param      <type>   $city_id  The city identifier
	 * @param      <type>   $cat_id   The cat identifier
	 * @param      boolean  $view     The view
	 */
	function get_sub_categories( $city_id, $cat_id = 0, $view = true )
	{
		$sub_cats = array();

		if ( $cat_id == 0 ) {
			$sub_cats = $this->sub_category->get_all_by( $city_id )->result();
		} else {
			$conds = array( 'cat_id' => $cat_id );
			$sub_cats = $this->sub_category->get_all_by( $city_id, $conds )->result();
		}

		if ( !$view ) {
			return $sub_cats;
		}

		$this->show_dropdown( $sub_cats, 'All Sub Categories', 'sub-cat-select' );
	}

	/**
	 * Get Categories JSON
	 *
	 * @param      <type>  $city_id  The city identifier
	 */
	function ajx_get_sub_cats( $city_id, $cat_id = 0 )
	{
		$sub_cat = $this->sub_category->get_empty_object('cd_sub_categories');
		$sub_cat->id = 0;
		$sub_cat->name = "All Sub Categories";
		$sub_cats[0] = $sub_cat;

		$sub_cats = array_merge( $sub_cats, $this->get_sub_categories( $city_id, $cat_id, false ));

		echo json_encode( $sub_cats );
	}

	/**
	 * Universal function for drop down view, used by get_categories, get_subcategories
	 *
	 * @param      <type>  $data        The data
	 * @param      <type>  $name        The name
	 * @param      string  $class_name  The class name
	 */
	function show_dropdown( $data, $name, $class_name )
	{
		$options = array( '0' => $name );
		if ( !empty( $data )) {
			foreach ( $data as $c ) {
				$options[$c->id] = $c->name;
			}
		}

		echo form_dropdown( $name, $options, 0, "class='select ". $class_name ." '" );
	}
}