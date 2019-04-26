<?php
/**
 * Item Detail Page Front End Controller
 * 
 */
include_once( APPPATH .'controllers/Main.php' );

class ItemInfo extends Main 
{

	// theme folder name
	protected $theme;

	// data object to pass to view
	protected $data;

	// comment list limit to show
	protected $cmt_limit;

	/**
	 * Construst required variables
	 */
	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );
		$this->theme = "templates/front-end/";
		$this->cmt_limit = 3;

		$this->data['dir'] = $this->theme;
		$this->data['page_id'] = 'item';
		$this->data['cmt_limit'] = 3;
	}

	/**
	 * item page function
	 */
	function index( $item_id )
	{
		/* prepare required data */
		// get item info
		$item = $this->get_item_info( $item_id );

		$this->data['item'] = $item;

		// load views
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'item');
		$this->load->view( $this->theme .'footer');
	}

	/**
	 * Helps to collect all item info
	 *
	 * @param      <type>  $item_id  The item identifier
	 *
	 * @return     <type>  The item information.
	 */
	function get_item_info( $item_id ) 
	{

		// get item info
		$item = $this->item->get_info( $item_id );

		// get item images
		$item->images = $this->image->get_all_by_type( $item->id, 'item' )->result();

		$conds = array( 'item_id' => $item_id );

		// get like count
		$item->likes = $this->like->get_all_by( $item->city_id, $conds )->result();

		// get review count
		$item->reviews = $this->review->get_all_by( $item->city_id, $conds, $this->cmt_limit )->result();

		// get favourite count
		$item->favourites = $this->favourite->get_all_by( $item->city_id, $conds )->result();

		/* check if logged in user already like or favourite */
		$item->like_by_user = false;
		$item->fav_by_user = false;
		if ( null !== $this->session->userdata('user_id')) {
		// if the user is already logged in 
			
			$user_id = $this->session->userdata('user_id');

			if ( !empty( $item->likes )) {
			// if item like array is not empty
				foreach ( $item->likes as $like ) {
					if ( $like->appuser_id == $user_id ) {
						$item->like_by_user = true;
					}
				}
			}

			if ( !empty( $item->favourites )) {
			// if item fav array is not empty
				foreach ( $item->favourites as $fav ) {
					if ( $fav->appuser_id == $user_id ) {
						$item->fav_by_user = true;
					}
				}
			}
		}

		return $item;
	}

	/**
	 * submits inquiry via Ajax
	 *
	 * @param      <type>  $item_id  The item identifier
	 * @param      <type>  $city_id  The city identifier
	 */
	function submit_inquiry ( $item_id, $city_id )
	{
		// get posted data
		$data = array(
			'item_id' => $item_id,
			'city_id' => $city_id,
			'name' => $_REQUEST['name'],
			'email' => $_REQUEST['email'],
			'message' => $_REQUEST['msg'],
		);
		
		// save inquiry
		if ( $this->inquiry->save($data) ) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/**
	 * Has more reviews.
	 *
	 * @param      <type>  $city_id  The city identifier
	 * @param      <type>  $item_id  The item identifier
	 * @param      <type>  $start    The start
	 */
	function has_more_reviews( $city_id, $item_id, $start = 0 )
	{
		$conds = array( 'item_id' => $item_id );

		$count = $this->review->count_all_by( $city_id, $conds, $this->cmt_limit, $start );

		if ( $count > 0 ) echo "true";
		else echo "false";
	}

	/**
	 * Loads more reviews.
	 *
	 * @param      <type>  $city_id  The city identifier
	 * @param      <type>  $item_id  The item identifier
	 * @param      <type>  $start    The start
	 */
	function load_more_reviews( $city_id, $item_id, $start = 0 )
	{
		$conds = array( 'item_id' => $item_id );

		$reviews = $this->review->get_all_by( $city_id, $conds, $this->cmt_limit, $start )->result();

		$this->load->view( $this->theme .'comment-list', array( 'reviews' => $reviews ));
	}

	/**
	 * submits favourite for the item by logged in user
	 *
	 * @param      <type>   $city_id     The city identifier
	 * @param      <type>   $item_id     The item identifier
	 * @param      <type>   $user_id     The user identifier
	 * @param      boolean  $is_appuser  Indicates if appuser
	 */
	function submit_fav( $city_id, $item_id, $user_id, $is_appuser )
	{
		if ( !$this->user->is_logged_in() ) {
			echo "false";
			die;
		}

		$user = $this->user->get_logged_in_user_info();

		//submit fav
		$data = array(
			'appuser_id' => $user->user_id,
			'item_id' => $item_id,
			'city_id' => $city_id,
			'is_appuser' => $user->is_appuser
		);

		if ( $this->favourite->exists( $data )) {
				
			$this->favourite->un_favourite($data);

			$count = $this->favourite->count_all( $city_id, $item_id);
			
		} else {
		
			$this->favourite->save($data);

			$count = $this->favourite->count_all( $city_id, $item_id);
		}
		
		//echo last fav count
		echo $count;
	}

	/**
	 * submits like for the item by logged in user
	 *
	 * @param      <type>   $city_id     The city identifier
	 * @param      <type>   $item_id     The item identifier
	 * @param      <type>   $user_id     The user identifier
	 * @param      boolean  $is_appuser  Indicates if appuser
	 */
	function submit_like( $city_id, $item_id, $user_id, $is_appuser )
	{
		if ( !$this->user->is_logged_in() ) {
			echo "false";
			die;
		}

		$user = $this->user->get_logged_in_user_info();

		//submit like
		$data = array(
			'appuser_id' => $user->user_id,
			'item_id' => $item_id,
			'city_id' => $city_id,
			'is_appuser' => $user->is_appuser
		);

		if ( $this->like->exists( $data )) {
				
			$this->like->un_like($data);

			$count = $this->like->count_all( $city_id, $item_id);
			
		} else {
		
			$this->like->save($data);

			$count = $this->like->count_all( $city_id, $item_id);
		}
		
		//echo last fav count
		echo $count;
	}

	/**
	 * submits review for the item by logged in user
	 *
	 * @param      <type>   $city_id     The city identifier
	 * @param      <type>   $item_id     The item identifier
	 * @param      <type>   $user_id     The user identifier
	 * @param      boolean  $is_appuser  Indicates if appuser
	 */
	function submit_review( $city_id, $item_id, $user_id, $is_appuser )
	{
		if ( !$this->user->is_logged_in() ) {
			echo "false";
			die;
		}

		$user = $this->user->get_logged_in_user_info();
		
		$review = htmlentities( $_REQUEST['review'] );

		$data = array(
			'item_id' => $item_id,
			'appuser_id' => $user->user_id,
			'city_id' => $city_id,
			'is_appuser' => $user->is_appuser,
			'review' => $review
		);
		
		if ( $this->review->save( $data )) {

			$obj = $this->review->get_info( $data['id'] );
			$this->load->view( $this->theme .'comment-list', array( 'reviews' => array( $obj )));
		} else {
			echo "false";
		}
	}
}