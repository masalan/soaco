<?php
/**
 * Profile Page Front End Controller
 * 
 */
include_once( APPPATH .'controllers/Main.php' );

class Profile extends Main {

	// theme folder name
	protected $theme;

	// data object to pass to view
	protected $data;

	// limit to show likes, favs, comments
	protected $limit;

	/**
	 * constrcuts required data
	 */
	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );
		$this->theme = "templates/front-end/";
		$this->limit = 3;

		$this->data['dir'] = $this->theme;
		$this->data['page_id'] = 'profile';
		$this->data['limit'] = $this->limit;
	}

	/**
	 * Profile Home Page Function
	 *
	 * @param      <type>  $user_id  The user identifier
	 */
	function index( $user_id, $is_appuser = 1 )
	{
		/** 
		 * Get User Info 
		 * Get Reviews
		 * Get Likes
		 * Get Favourites
		 */
		$user;

		// get user info
		if ( $is_appuser ) {
			$user = $this->appuser->get_info( $user_id );
		} else {
			$user = $this->user->get_info( $user_id );
		}
		$user = $this->user->get_adapter_object( $user );

		$conds = array(
			'appuser_id' => $user_id,
			'is_appuser' => $is_appuser
		);

		// get reviews, like, favourites
		$user->reviews = $this->review->get_all_by_user( $conds, $this->limit )->result();
		$user->likes = $this->like->get_all_by_user( $conds, $this->limit )->result();
		$user->favourites = $this->favourite->get_all_by_user( $conds, $this->limit)->result();

		/** Load Variables */
		$this->data['user'] = $user;

		/**
		 * Checks if the logged in user is looking his own profile
		 */
		$this->data['is_same_user'] = 0;
		if ( $this->user->is_logged_in()) {
			$logged_user = $this->user->get_logged_in_user_info();

			if ( $logged_user->user_id == $user_id ) {
				$this->data['is_same_user'] = 1;
			}
		}

		/** Load Profile View */
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'profile' );
		$this->load->view( $this->theme .'footer' );
	}

	/**
	 * updates user information (about me & email )
	 *
	 * @param      <type>  $user_id  The user identifier
	 */
	function update_profile( $user_id, $is_appuser )
	{
		if ( !$this->user->is_logged_in() ) {
			echo "false";
			die;
		}

		$user = $this->user->get_logged_in_user_info();
		$user_id = $user->user_id;
		$is_appuser = $user->is_appuser;

		// get post data
		$email = htmlentities( $_REQUEST['email'] );

		$data = array(
			'about_me' => htmlentities( $_REQUEST['aboutMe'] )
		);

		if ( $is_appuser ) {
		// if the user is app user, update in appuser table
			
			$data['email'] = $email;
			if ( $this->appuser->save( $data, $user_id )) {
				echo "true";
			} else {
				echo "Fail to update appuser table";
			}

		} else {
		// if the user is not app user, update in be user table
			
			$data['user_email'] = $email;
			if ( $this->user->update_profile( $data, $user_id )) {
				echo "true";
			} else {
				echo "Fail to update user table";
			}
		}
	}

	/**
	 * loads more reviews
	 *
	 * @param      <type>   $appuser_id  The appuser identifier
	 * @param      integer  $start       The start
	 */
	function has_more_reviews( $appuser_id, $is_appuser, $start = 0 )
	{
		$conds = array(
			'appuser_id' => $appuser_id,
			'is_appuser' => $is_appuser
		);

		$count = $this->review->get_all_by_user( $conds, $this->limit, $start, true );

		if ( $count > 0 ) echo "true";
		else echo "false";
	}

	/**
	 * loads more reviews
	 *
	 * @param      <type>   $appuser_id  The appuser identifier
	 * @param      integer  $start       The start
	 */
	function load_more_reviews( $appuser_id, $is_appuser, $start = 0 )
	{
		$conds = array(
			'appuser_id' => $appuser_id,
			'is_appuser' => $is_appuser
		);

		$reviews = $this->review->get_all_by_user( $conds, $this->limit, $start )->result();

		$this->load->view( $this->theme .'review-list', array( 'reviews' => $reviews ));
	}

	/**
	 * loads more favourites
	 *
	 * @param      <type>   $appuser_id  The appuser identifier
	 * @param      integer  $start       The start
	 */
	function load_more_favs( $appuser_id, $is_appuser, $start = 0 )
	{
		$conds = array(
			'appuser_id' => $appuser_id,
			'is_appuser' => $is_appuser
		);

		$favs = $this->favourite->get_all_by_user( $conds, $this->limit, $start )->result();

		$this->load->view( $this->theme .'fav-list', array( 'favourites' => $favs ));
	}

	/**
	 * loads more favourites
	 *
	 * @param      <type>   $appuser_id  The appuser identifier
	 * @param      integer  $start       The start
	 */
	function has_more_favs( $appuser_id, $is_appuser, $start = 0 )
	{
		$conds = array(
			'appuser_id' => $appuser_id,
			'is_appuser' => $is_appuser
		);

		$count = $this->favourite->get_all_by_user( $conds, $this->limit, $start, true );

		if ( $count > 0 ) echo "true";
		else echo "false";
	}

	/**
	 * loads more likes
	 *
	 * @param      <type>   $appuser_id  The appuser identifier
	 * @param      integer  $start       The start
	 */
	function load_more_likes( $appuser_id, $is_appuser, $start = 0 )
	{
		$conds = array(
			'appuser_id' => $appuser_id,
			'is_appuser' => $is_appuser
		);

		$likes = $this->like->get_all_by_user( $conds, $this->limit, $start )->result();

		$this->load->view( $this->theme .'like-list', array( 'likes' => $likes ));
	}

	/**
	 * loads more likes
	 *
	 * @param      <type>   $appuser_id  The appuser identifier
	 * @param      integer  $start       The start
	 */
	function has_more_likes( $appuser_id, $is_appuser, $start = 0 )
	{
		$conds = array(
			'appuser_id' => $appuser_id,
			'is_appuser' => $is_appuser
		);

		$count = $this->like->get_all_by_user( $conds, $this->limit, $start, true );

		if ( $count > 0 ) echo "true";
		else echo "false";
	}

	function update_profile_photo( $user_id, $is_appuser )
	{
		if ( !$this->user->is_logged_in() ) {
			echo "false";
			die;
		}

		$user = $this->user->get_logged_in_user_info();
		$user_id = $user->user_id;
		$is_appuser = $user->is_appuser;
		
		$status = "";
	    $msg = "";
	    $file_element_name = 'profileImg';
	        
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = $this->config->item('image_type');
 
        $this->load->library('upload');

        $this->upload->initialize( $config );
 
        if ( ! $this->upload->do_upload( $file_element_name ))
        {
            echo json_encode( array(
            	'status' => 'error',
            	'msg' => $this->upload->display_errors()
            ));
        }
        else
        {
        	$uploaded_data = $this->upload->data(); 
        	$filename = $uploaded_data['file_name'];

			$user_data = array( 'profile_photo' => $filename );

        	if ( $is_appuser == 1 ) {
        		if ( $this->appuser->save( $user_data, $user_id ) ) {

        			echo json_encode( array(
        				'status' => 'success',
        				'path' => base_url('/uploads/'. $filename )
        			));
        		} else {
        			
        			echo json_encode( array( 'status' => 'error in updating app user profile' ));
        		}
        	} else {
        		if ( $this->user->update_profile( $user_data, $user_id )) {
        			
        			echo json_encode( array(
        				'status' => 'success',
        				'path' => base_url('/uploads/'. $filename )
        			));
        		} else {
        			
        			echo json_encode( array( 'status' => 'error in updating user profile' ));
        		}
        	}
        }
	}
}