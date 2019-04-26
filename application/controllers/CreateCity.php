<?php
/**
 * Create City Page Controller
 * 
 */
include_once( APPPATH .'/controllers/Main.php' );

class CreateCity extends main
{
	// theme name
	protected $theme;

	// data to load for view
	protected $data;

	/**
	 * constructs required variables
	 */
	function __construct()
	{
		parent::__construct( NO_LOGIN_CONTROL );


		// assign variables
		$this->theme = "templates/front-end/";
		$this->data['dir'] = $this->theme;
		$this->data['page_id'] = "create-city";

		// load paypal library
		$this->load_paypal();
        
        // load email library
		$this->load->library('email',array(
			'mailtype'  => 'html',
			'newline'   => '\r\n'
		));

		// load uploader
		$this->load->library('uploader');
	}

	/**
	 * loads paypal config and libraries
	 */
	function load_paypal()
	{
		// Load PayPal config
        $this->config->load('paypal');

        //prepare paypal config
        $config = array(

        	// Sandbox / testing mode option.
            'Sandbox' => $this->config->item('Sandbox'),

            // PayPal API username of the API caller
            'APIUsername' => $this->config->item('APIUsername'),

            // PayPal API password of the API caller
            'APIPassword' => $this->config->item('APIPassword'),

            // PayPal API signature of the API caller
            'APISignature' => $this->config->item('APISignature'),

            // PayPal API subject (email address of 3rd party user that has granted API permission for your app)   
            'APISubject' => '',

            // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'APIVersion' => $this->config->item('APIVersion')
        );

        if ($config['Sandbox']) {
        // if paypal is testing,open error reporting
        
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        // load paypal library
        $this->load->library('paypal/Paypal_pro', $config);
	}

	/**
	 * Create City Page Main Function
	 */
	function index()
	{
		if ( $this->input->server('REQUEST_METHOD') == 'POST' ) {
		// if the http method is POST, create user and city

			/* Start database transaction */
			$this->db->trans_begin();

				/* upload images */
				$upload_data = $this->uploader->upload($_FILES);
				if ( isset( $upload_data['error'] )) {
				// if there is any error in uploading, show error and stop processing
					
					$this->session->set_flashdata( 'error', $upload_data['error']);
					$this->db->trans_rollback();
					redirect( site_url( 'CreateCity' ));
				}
					
				/* create or convert admin user */
				if ( ! $this->process_user_data( $user_data )) {
				// if there is any error in creating/converting user, redirect itself

					$this->db->trans_rollback();
					redirect( site_url( 'CreateCity' ));
				}
			
				/* create city */
				$admin_id = $user_data['user_id'];

				if ( ! $this->process_city_data( $city_data, $admin_id )) {
				// if there is any error in creating city, redirect itself

					$this->db->trans_rollback();
					redirect( site_url( 'CreateCity' ));
				}

				/* insert cover photo data */
				$city_id = $city_data['id'];

				if ( ! $this->process_coverphoto( $upload_data, $city_id, $image)) {
				// if there is any error in inserting city cover photo, redirect itself

					$this->db->trans_rollback();
					redirect( site_url( 'CreateCity' ));
				}

				/* Send Email to administrator */
				if ( ! $this->email_to_admin() ) {
					
					$this->db->trans_rollback();
					redirect( site_url( 'CreateCity' ));
				}

			/* commit database tranctions */
			if ( $this->db->trans_status() == FALSE) {
			    $this->db->trans_rollback();
			} else {
			    $this->db->trans_commit();
			}

			/* do paypal transaction */
			if ( $this->paypal_config->is_paypal_enable()) {
			// if paypal is enable,
			
				if ( ! $this->set_express_checkout( $city_data )) {
				// if there is an error in paypal transaction, redirect itself
					
					$this->session->set_flashdata( 'error', $this->lang->line('f_err_paypal_trans'));
					$this->db->trans_rollback();
					redirect( site_url( 'CreateCity' ));
				}
			} else {
				redirect( site_url('CreateCity/success'));
			}
		}

		/* load views */
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'nav' );
		$this->load->view( $this->theme .'create-city' );
		$this->load->view( $this->theme .'footer' );
	}

	/**
	 * Success page after city registration
	 */
	function success()
	{	
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'nav' );
		$this->load->view( $this->theme .'success' );
		$this->load->view( $this->theme .'footer' );
	}

	/**
	 * create new user or convert to backend user if the user is front-end user
	 *
	 * @param      <type>  $user_data    The user data
	 * @param      <type>  $permissions  The permissions
	 */
	function process_user_data( &$user_data )
	{
		// prepare user data
		$user_data = $this->prepare_user_data();

		if ( $this->user->is_logged_in() && !$this->user->is_frontend_user()) {
		// if the user is back-end user, no need to process user creating, just return true
			$user_data['user_id'] = $this->session->userdata('user_id');
			return true;
		}

		// prepare permissions
		$permissions = $this->prepare_permissions();

		if ( ! $this->user->save( $user_data, $permissions )) {
		// if there is an error in creating user, show error and redirect itself
			
			$this->session->set_flashdata( 'error', $this->lang->line('f_err_create_user'));
			return false;
		}

		if ( $this->user->is_frontend_user()) {
		// if front-end user, process appuser to BeUser migration

			// get app user id
			$appuser_id = $this->session->userdata('user_id');

			// delete app user
			if ( ! $this->appuser->delete( $appuser_id )) {
				$this->session->set_flashdata( 'error', $this->lang->line('f_err_del_appuser'));
				return false;
			}

			// filter options
			$conds = array(
				'appuser_id' => $appuser_id,
				'is_appuser' => 1
			);

			// updated data
			$data = array(
				'appuser_id' => $user_data['user_id'],
				'is_appuser' => 0
			);

			// update comments
			if ( ! $this->review->update_by( $data, $conds )) {
				$this->session->set_flashdata( 'error', $this->lang->line('f_err_migrate_review'));
				return false;
			}
				
			// update likes
			if ( ! $this->like->update_by( $data, $conds )) {
				$this->session->set_flashdata( 'error', $this->lang->line('f_err_migrate_like'));
				return false;
			}

			// update favourites
			if ( ! $this->favourite->update_by( $data, $conds )) {
				$this->session->set_flashdata( 'error', $this->lang->line('f_err_migrate_fav'));
				return false;
			}
		}

		return true;
	}

	/**
	 * process city data
	 *
	 * @param      <type>   $admin_id  The admin identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function process_city_data( &$city_data, $admin_id )
	{
		/* prepare city data */
		$city_data = $this->prepare_city_data( $admin_id );
	
		/* create city */
		if ( ! $this->city->save( $city_data )) {

			$this->session->set_flashdata( 'error', $this->lang->line('f_err_create_city'));
			return false;
		}

		return true;
	}

	/**
	 * process cover photo for city
	 *
	 * @param      <type>   $upload_data  The upload data
	 * @param      <type>   $city_id      The city identifier
	 * @param      array    $image        The image
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function process_coverphoto( $upload_data, $city_id, &$image)
	{
		if ( ! empty( $upload_data )) {
			$upload = $upload_data[0];
			
			$image = array(
				'parent_id' => $city_id,
				'type' => 'city',
				'description' => htmlentities( $this->input->post('image_desc')),
				'path' => $upload['file_name'],
				'width' => $upload['image_width'],
				'height' => $upload['image_height']
			);

			if ( ! $this->image->save( $image )) {
				$this->session->set_flashdata( 'error', $this->lang->line('f_err_cover_photo'));
				return false;
			}
		}

		return true;
	}

	/**
	 * prepare user data
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function prepare_user_data()
	{
		if ( $this->user->is_logged_in()) {
		// if user is currently logged in, return current user data
		
			// get logged in user
			$user_data = $this->user->get_logged_in_user_info();

			// return user data
			return array(
				'user_name' => $user_data->user_name, 
				'user_email' => $user_data->user_email,
				'user_pass' => $user_data->user_pass,
				'is_city_admin' => 1,
				'role_id' => 4, // 4 is city admin
				'about_me' => $user_data->about_me,
				'profile_photo' => $user_data->profile_photo
			);

		} else {
		// if new user, prepare data by POST varaibles

			// return user data
			return array(
				'user_name' => htmlentities( $this->input->post( 'user_name' )), 
				'user_email' => htmlentities( $this->input->post( 'user_email' )),
				'user_pass' => md5( htmlentities( $this->input->post( 'user_password' ))),
				'is_city_admin' => "1",
				'role_id' => 4
			);
		}
	}

	/**
	 * prepare permissions
	 *
	 * @return     array  ( description_of_the_return_value )
	 */
	function prepare_permissions()
	{
		$permissions = array();
		// get all modules and assign to cityadmin
		foreach ( $this->module->get_all()->result() as $module ) {

			if ( $module->module_name != "users" ) {
			// except 'users' module, all modules will be assigned

				$permissions[] = $module->module_id;
			}
		}

		return $permissions;
	}

	/**
	 * prepare city data
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function prepare_city_data( $admin_id )
	{
		// get city user data
		return array(
			'name' => htmlentities( $this->input->post( 'name' )),
			'description' => htmlentities( $this->input->post( 'description' )),
			'address' => htmlentities( $this->input->post( 'address' )),
			'lat' => htmlentities( $this->input->post( 'lat' )),
			'lng' => htmlentities( $this->input->post( 'lng' )),
			'is_approved' => 0,
			'admin_id' => $admin_id
		);
	}

	/**
	 * prepare paypal data
	 *
	 * @param      <type>   $city_data    The city data
	 * @param      array    $payments     The payments
	 * @param      array    $fields       The fields
	 * @param      boolean  $is_callback  Indicates if callback
	 */
	function prep_paypal_data( $city_data, &$payments, &$fields, $is_callback = false )
	{
        // get paypal data
        $paypal_info = $this->paypal_config->get();

		// Payment Data
        $payments = array();
        $payment = array(
            'amt' => $paypal_info->price,
            'currencycode' => $paypal_info->currency_code, 
        );

		// prepare SECF and DECP data, items info
        if ( $is_callback ) {

        	$token = $this->input->get( 'token' );
	        $payer_id = $this->input->get( 'PayerID' );

	        $fields = array(
	        	// Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
	            'token' => $token,

	            'payerid' => $payer_id,
	            'surveyquestion' => ''
            );
	        
        } else {
        	$fields = array(
        		// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
	            'returnurl' => site_url( 'CreateCity/do_express_checkout_payment/'. $city_data['id'] ),

	            'cancelurl' => site_url( 'CreateCity/do_express_checkout_payment/'. $city_data['id'] ),

	            'surveyquestion' => ''
	        );

	        // Payment Item
	        $payment_order_items = array();
	        $item = array(
				'name' => $city_data['name'],
				'desc' => 'Registration fees for creating new city`',
				'amt' => $paypal_info->price,
				'qty' => '1'
	        );
	        array_push($payment_order_items, $item);

	        // Add payment item to payment data
	        $payment['order_items'] = $payment_order_items;
        }

        array_push($payments, $payment);
	}

	/**
	 * Sets the express checkout.
	 *
	 * @param      boolean  $city_data  The city data
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function set_express_checkout( $city_data = false )
	{
		// prepare transaction info
        $this->prep_paypal_data( $city_data, $Payments, $SECFields );

        $PayPalRequestData = array(
            'SECFields' => $SECFields,
            'Payments' => $Payments,
            'BuyerDetails' => array(),
            'ShippingOptions' => array(),
            'BillingAgreements' => array()
        );

        $PayPalResult = $this->paypal_pro->SetExpressCheckout( $PayPalRequestData );

        if ( ! $this->paypal_pro->APICallSuccessful( $PayPalResult['ACK'] )) {
        	//var_dump( $PayPalResult['ERRORS'] );
        	return false;
        } else {
            redirect( 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $PayPalResult['TOKEN'] );
            // Successful call.  Load view or whatever you need to do here.
        }
	}

	/**
	 * paypal do_express_checkout_payment
	 *
	 * @param      boolean  $city_id  The city identifier
	 */
	function do_express_checkout_payment( $city_id = false )
    {
    	$this->prep_paypal_data( array(), $Payments, $DECPFields, true );

    	$PayPalRequestData = array(
            'DECPFields' => $DECPFields,
            'Payments' => $Payments,
            'UserSelectedOptions' => array()
        );

        $PayPalResult = $this->paypal_pro->DoExpressCheckoutPayment($PayPalRequestData);

        if ( ! $this->paypal_pro->APICallSuccessful( $PayPalResult['ACK'] )) {

            //var_dump( $PayPalResult['ERRORS'] );
            $this->session->set_flashdata( 'error', $this->lang->line('f_err_paypal_trans'));

        } else {

        	if ( $PayPalResult['PAYMENTINFO_0_ACK'] != 'Success' ) {
        		$this->session->set_flashdata( 'error', $this->lang->line('f_err_paypal_trans'));
        		redirect(site_url('login'));
        	}

        	$city_data = array( 'paypal_trans_id' => $PayPalResult['PAYMENTINFO_0_TRANSACTIONID'] );

        	if ( ! $this->city->save( $city_data, $city_id )) {
        		$this->session->set_flashdata( 'error', $this->lang->line('f_err_paypal_trans'));
        		redirect(site_url('login'));
        	}

        	//$this->session->set_flashdata( 'success', 'Congratulation! New City has been created' );
            // Successful call.  Load view or whatever you need to do here.
   			// $this->load->view( 'message' );
			// return;
        	redirect( site_url('CreateCity/success'));
        }
            
        redirect( site_url( 'login' ));
    }

    /**
     * emails to admin
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    function email_to_admin()
	{
		// get email configuration
		$sender_email = $this->config->item( 'sender_email' );
		$sender_name = $this->config->item( 'sender_name' );
		$admin_email = $this->config->item( 'admin_email' );

		// prepare subject and message
		$url = site_url();
	   	$subject = 'New Cities are waiting for approval';
		$html = <<<EOT
<p>Hi</p>

<p>Good day.</p>

<p>New Cities are waiting for approval.</p>
<a href='$url'>Go to City Directory</a>

<p>
	Best Regards,<br/>
	<em>Cities Directory</em>
<p>
EOT;
	
		// configure email		
		$this->email->from($sender_email,$sender_name);
		$this->email->to($admin_email); 
		$this->email->subject($subject);
		$this->email->message($html);	

		// send email
		if ( ! $this->email->send()) {

			$this->session->set_flashdata( 'error', $this->lang->line('f_err_email_send'));
			return false;
		}

		return true;
	}

	/**
	 * check if the email is already existed
	 *
	 * @param      <type>  $user_id  The user identifier
	 */
	function exists()
	{
		$user_email = $_REQUEST['user_email'];
		
		if( $this->appuser->exists( array( 'email'=> $user_email ))) {
			echo "false";
		} else if( $this->user->exists( array( 'user_email'=> $user_email ))) {
			echo "false";
		} else {
			echo "true";
		}
	}
}