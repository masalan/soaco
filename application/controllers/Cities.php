<?php
require_once('Main.php');
class Cities extends Main
{
	function __construct()
	{
		parent::__construct( NO_ACCESS_CONTROL );

		// Load PayPal library
        $this->config->load('paypal');

        $config = array(
            'Sandbox' => $this->config->item('Sandbox'),            // Sandbox / testing mode option.
            'APIUsername' => $this->config->item('APIUsername'),    // PayPal API username of the API caller
            'APIPassword' => $this->config->item('APIPassword'),    // PayPal API password of the API caller
            'APISignature' => $this->config->item('APISignature'),    // PayPal API signature of the API caller
            'APISubject' => '',                                    // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersion')        // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
        );

        // Show Errors
        if ($config['Sandbox']) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        $this->load->library('paypal/Paypal_pro', $config);

		$this->load->library('email',array(
       		'mailtype'  => 'html',
        	'newline'   => '\r\n'
		));
		$this->load->library('uploader');
	}
	
	function index()
	{

        if ($this->session->userdata('role_id') == 5)
            redirect(site_url('soaco_e-Station/'.url_encode($this->user->get_logged_in_user_info()->user_id)), 'refresh');
        if ($this->session->userdata('role_id') == 6)
            redirect(site_url('soaco_e-Station/'.url_encode($this->user->get_logged_in_user_info()->user_id)), 'refresh');
        if ($this->session->userdata('role_id') == 7)
            redirect(site_url( "company"), 'refresh');

	    $this->session->unset_userdata('city_id');
	
		$cities = array();

		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$searchterm = htmlentities($this->input->post('searchterm'));

			if ( $this->user->is_system_user() ) {

				$cities = $this->city->get_all_by( array( 
					'searchterm' => $searchterm,
					'is_approved' => APPROVE 
				))->result();
			} else {

				$cities = $this->city->get_all_by( array( 
					'searchterm' => $searchterm, 
					'admin_id' => $this->user->get_logged_in_user_info()->user_id,
					'is_approved' => APPROVE 
				))->result();	
			}
			
			$data['searchterm'] = $searchterm;
		} else {
			if ( $this->user->is_system_user() ) {
				$cities = $this->city->get_all( array() )->result();
			} else {
				$cities = $this->city->get_all_by( array( 
					'admin_id' => $this->user->get_logged_in_user_info()->user_id, 
					'is_approved' => APPROVE 
				))->result();
			}
		}
		// 		$this->db->where('country_id',$this->session->userdata('country_id'));
		$temp_cities_arr = array();
		foreach ($cities as $city) {
			$img = $this->image->get_all_by_type($city->id, 'city')->result();

			if ( count( $img ) > 0 ) {
				$city->image = $img[0]->path;
			} else {
				$city->image = "";
			}
			$temp_cities_arr[] = $city;
		}
		$data['cities'] = $temp_cities_arr;
		$this->load->view('cities/list', $data);
	}
	
	function create()
	{
		if(!$this->session->userdata('is_city_admin')) {
		      $this->check_access('add');
		}
		if ($this->input->server('REQUEST_METHOD')=='POST') {			
			$upload_data = $this->uploader->upload($_FILES);
			
			if (!isset($upload_data['error'])) {
				$city_data = $this->input->post();

				$temp = array();
				foreach ( $city_data as $key => $value ) {
					$temp[$key] = htmlentities($value);					
				}
				$city_data = $temp;

				$img_desc = $city_data['image_desc'];
				unset($city_data['image_desc']);
				unset($city_data['images']);
				unset($city_data['find_location']);

				$city_data['admin_id'] = $this->user->get_logged_in_user_info()->user_id;
				
				$city_data['name'] = htmlentities($this->input->post('name'));
				$city_data['description'] = htmlentities($this->input->post('description'));
				$city_data['address'] = htmlentities($this->input->post('address'));
				$city_data['lat'] = htmlentities($this->input->post('lat'));
				$city_data['lng'] = htmlentities($this->input->post('lng'));
                $city_data['country_id'] = htmlentities($this->input->post('country_id'));

                if(!$this->user->is_system_user()) {
					$city_data['is_approved'] = 0;
					$city_data['status'] = 0;
				} else {
					$city_data['is_approved'] = 1;
					$city_data['status'] = 1;
				}
				
				if ( ! $this->city->save($city_data)) {
					$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
				}

				foreach ($upload_data as $upload) {
					$image = array(
						'parent_id'=>$city_data['id'],
						'type' => 'city',
						'description' => $img_desc,
						'path' => $upload['file_name'],
						'width'=>$upload['image_width'],
						'height'=>$upload['image_height']
					);
					$this->image->save($image);
				}
					
				// send email to admin
				if ( ! $this->email_to_admin() ) {
					$this->session->set_flashdata( 'error', 'Error occured in email sending');
				}
				
				if(!$this->user->is_system_user()) {
					if ( $this->paypal_config->is_paypal_enable()) {
						if ( ! $this->set_express_checkout( $city_data )) {
							$this->session->set_flashdata( 'error', 'Error occured in paypal transaction');
						}
					}
				}
						
				$this->session->set_flashdata( 'success', 'Congratulation! New city has been created' );
				redirect(site_url('cities/create'));
			} else {

				$this->session->set_flashdata( 'success', $upload_data['error'] );
				redirect(site_url('cities/create'));
			}
		}
		
		$content['content'] = $this->load->view('cities/create',array(),true);
		$this->load_template($content,false);
	}

	
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
<a href='$url'>Go to SOACO e-Station </a>

<p>
	Best Regards,<br/>
	<em> SOACO e-Station </em>
<p>
EOT;
	
		// configure email		
		$this->email->from($sender_email,$sender_name);
		$this->email->to($admin_email); 
		$this->email->subject($subject);
		$this->email->message($html);	

		// send email
		if ( ! $this->email->send()) {
			return false;
		}

		return true;
	}

	function approval()
	{
		if( $this->session->userdata('is_city_admin')) {
		    return;
		}

		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('cities/index');
		$pag['total_rows'] = count( $this->city->get_all_by( array( 'is_approved' => 0 ))->result());

		$data['cities'] = $this->city->get_all_by( array( 'is_approved' => 0 ), $pag['per_page'], $this->uri->segment(3));
		$data['pag'] = $pag;

		$content['content'] = $this->load->view( 'cities/approval', $data, true);
		$this->load_template( $content, false);
	}

	function paypal_config()
	{
		if( $this->session->userdata('is_city_admin')) {
		    return;
		}

		if ( $this->input->server( 'REQUEST_METHOD' ) == 'POST' ) {
			$config = array(
				'status' => htmlentities($this->input->post( 'status' )),
				'price' => htmlentities($this->input->post( 'price' )),
				'currency_code' => htmlentities($this->input->post( 'currency' ))
			);

			if ( ! $this->paypal_config->save( $config )) {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}

			$this->session->set_flashdata('success','Paypal Configuration is successfully updated.');
			redirect( site_url( 'cities/paypal_config' ));
		}

		$data['paypal_config'] = $this->paypal_config->get_paypal_config();
		$content['content'] = $this->load->view( 'cities/paypal_config', $data, true);
		$this->load_template( $content, false);
	}
	
	function send_gcm() 
	{
		if( $this->session->userdata('is_city_admin')) {
		    return;
		}
		$content['content'] = $this->load->view( 'gcm/form', array(), true );
		$this->load_template($content, false);
	}
	
	function push_message() 
	{
		if ( $this->input->server( 'REQUEST_METHOD' ) == "POST" ) {
			$message = $this->input->post( 'message' );

			$error_msg = "";
			$success_device_log = "";

			// Android Push Notification
			$devices = $this->gcm_token->get_all_by(array('os_type' => 'ANDROID'))->result();;

			$reg_ids = array();
			if ( count( $devices ) > 0 ) {
				foreach ( $devices as $device ) {
					$reg_ids[] = $device->reg_id;
				}
			}

			$status = $this->sendMessageThroughFCM( $reg_ids, array( "message" => $message ));
			if ( !$status ) $error_msg .= "Fail to push all android devices <br/>";

			// IOS Push Notification
			$devices = $this->gcm_token->get_all_by(array('os_type' => 'IOS'))->result();;

			if ( count( $devices ) > 0 ) {
				foreach ( $devices as $device ) {
					if ( ! $this->sendMessageThroughIOS( $device->reg_id, $message )) {
						$error_msg .= "Fail to push ios device named ". $device->reg_id ."<br/>";
						//echo $error_msg;
					} else {
						//echo " Sent to : " . $device->reg_id;
						$success_device_log .= " Device Id : " . $device->reg_id . "<br>";
					}
				}
			}
			//die;
			// response message
			if ( $status ) {
				$this->session->set_flashdata( 'success', "Successfully Sent Push Notification.<br>" . $success_device_log );
			}

			if ( !empty( $error_msg )) {
				$this->session->set_flashdata( 'error', $error_msg );
			}

			redirect( 'cities/send_gcm' );
		}

		$content['content'] = $this->load->view( 'gcm/form', array(), true );
		
		$this->load_template($content, false);
	}

	function sendMessageThroughIOS($tokenId, $message) 
	{
		ini_set('display_errors','On'); 
		error_reporting(E_ALL);
		// Change 1 : No braces and no spaces
		$deviceToken= $tokenId;
		//'fe2df8f5200b3eb133d84f73cc3ea4b9065b420f476d53ad214472359dfa3e70'; 
		// Change 2 : If any
		$passphrase = 'teamps12345'; 
		//$message = 'Yoo Tp';
		$ctx = stream_context_create();
		// Change 3 : APNS Cert File name and location.
		stream_context_set_option($ctx, 'ssl', 'local_cert', realpath('application').'/apns/apns_cert_CD_2017_02.pem'); 
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client( 
		    'ssl://gateway.sandbox.push.apple.com:2195', $err,
		    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
		    exit("Failed to connect: $err $errstr" . PHP_EOL);
		//echo 'Connected to APNS' . PHP_EOL;
		// Create the payload body
		$body['aps'] = array(
		    'alert' => $message,
		    'sound' => 'default'
		    );
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		// Close the connection to the server
		fclose($fp);
		//var_dump($result); die;
		if (!$result) 
		    //echo 'Message not delivered' . PHP_EOL;
		    return false;

		//echo 'Message successfully delivered' . PHP_EOL;
		return true;
	}
	

	//Generic php function to send GCM push notification
   	function sendMessageThroughGCM( $registatoin_ids, $message) 
   	{
		//Google cloud messaging GCM-API url
		$url = 'https://android.googleapis.com/gcm/send';
		$fields = array(
		    'registration_ids' => $registatoin_ids,
		    'data' => $message,
		);
		// Update your Google Cloud Messaging API Key
		//define("GOOGLE_API_KEY", "AIzaSyCCwa8O4IeMG-r_M9EJI_ZqyybIawbufgg");
		define("GOOGLE_API_KEY", $this->config->item( 'gcm_api_key' ));  	
			
		$headers = array(
		    'Authorization: key=' . GOOGLE_API_KEY,
		    'Content-Type: application/json'
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);				
		if ($result === FALSE) {
		    die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
    }
    
    function sendMessageThroughFCM( $registatoin_ids, $message) 
    {
    	//Google cloud messaging GCM-API url
    	$url = 'https://fcm.googleapis.com/fcm/send';
    	$fields = array(
    	    'registration_ids' => $registatoin_ids,
    	    'data' => $message,
    	);
    	// Update your Google Cloud Messaging API Key
    	//define("GOOGLE_API_KEY", "AIzaSyCCwa8O4IeMG-r_M9EJI_ZqyybIawbufgg");
    	define("GOOGLE_API_KEY", $this->config->item( 'fcm_api_key' ));  	
    		
    	$headers = array(
    	    'Authorization: key=' . GOOGLE_API_KEY,
    	    'Content-Type: application/json'
    	);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    	$result = curl_exec($ch);				
    	if ($result === FALSE) {
    	    die('Curl failed: ' . curl_error($ch));
    	}
    	curl_close($ch);
    	
    	return $result;
    }
	

	function approve( $city_id = 0 )
	{
		$city_data = array( 'is_approved'=> APPROVE );

		$city = $this->city->get_info( $city_id );

		$user_email = $this->user->get_info( $city->admin_id )->user_email;
			
		if ( $this->city->save( $city_data, $city_id )) {
			if ( $this->email_to_user( $user_email )) {
				echo 'true';
			} else {
				echo 'email-error';
			}
		} else {
			echo 'false';
		}
	}

	function reject( $city_id = 0 )
	{
		$city_data = array( 'is_approved'=> REJECT );

		$city = $this->city->get_info( $city_id );

		$user_email = $this->user->get_info( $city->admin_id )->user_email;
			
		if ( $this->city->save( $city_data, $city_id )) {
			if ( $this->email_to_user( $user_email, false )) {
				echo 'true';
			} else {
				echo 'email-error';
			}
		} else {
			echo 'false';
		}
	}

	function detail( $city_id = 0 )
	{
		$data['city'] = $this->city->get_info( $city_id );

		$content['content'] = $this->load->view( 'cities/detail', $data, true );
		$this->load_template( $content, false, true );
	}
	
	function edit($data_id = 0 )
	{
        $city_id =url_decode($data_id);

	    if(!$this->session->userdata('is_city_admin')) {
			$this->check_access('edit');
		}
		
		$this->session->set_userdata('city_id', $city_id);
		$this->session->set_userdata('action', 'city_edit');
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			if (htmlentities($this->input->post('status'))!= 1) {
				$_POST['status'] = 0;
			}
			
			//$city_data = $this->input->post();
			$city_data['name'] = htmlentities($this->input->post('name'));
			$city_data['description'] = htmlentities($this->input->post('description'));
			$city_data['address'] = htmlentities($this->input->post('address'));
			$city_data['status'] = htmlentities($this->input->post('status'));
			$city_data['lat'] = htmlentities($this->input->post('lat'));
			$city_data['lng'] = htmlentities($this->input->post('lng'));
			
			
			
			if ($this->city->save($city_data, $city_id)) {
				$this->session->set_flashdata('success','City Information is successfully updated.');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			redirect(site_url('cities/edit/' . $city_id));
		}
		
		$data['city'] = $this->city->get_info($city_id);
		
		$content['content'] = $this->load->view('cities/edit',$data,true);
		$this->load_template($content,false,true);
	}
	
	function upload($city_id=0)
	{
		if(!$this->session->userdata('is_city_admin')) {
		    $this->check_access('edit');
		}
		
		$upload_data = $this->uploader->upload($_FILES);
		
		if (!isset($upload_data['error'])) {
			unlink('./uploads/'.$this->image->get_info_parent_type($city_id,'city')->path);
			unlink('./uploads/thumbnail/'.$this->image->get_info_parent_type($city_id,'city')->path);
			$this->image->delete_by_parent($city_id,'city');
			
			foreach ($upload_data as $upload) {
				$image = array(
					'parent_id'=> $city_id,
					'type' => 'city',
					'description' => htmlentities($this->input->post('image_desc')),
					'path' => $upload['file_name'],
					'width'=>$upload['image_width'],
					'height'=>$upload['image_height']
				);
				$this->image->save($image);
				$this->session->set_flashdata('success','City Information is successfully updated.');
				redirect(site_url('cities/edit/' . $city_id));
			}
			
		} else {
			$this->session->set_flashdata('error', $upload_data['error']);
			redirect(site_url('cities/edit/' . $city_id));
		}
		
		$data['city'] = $this->city->get_info($city_id);
		
		$content['content'] = $this->load->view('cities/edit',$data,true);
		$this->load_template($content);
	}
	
	function edit_image($city_id, $image_id)
	{
		if(!$this->session->userdata('is_city_admin')) {
		    $this->check_access('edit');
		}
		
		$image = array(
			'description' => htmlentities($this->input->post('image_desc'))
		);
			
		if ($this->image->save($image, $image_id)) {
			$this->session->set_flashdata('success','City cover photo description is successfully updated.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('cities/edit/' . $city_id));
	}

	function delete_image($city_id,$image_id,$image_name)
	{
		if(!$this->session->userdata('is_city_admin')) {
		    $this->check_access('edit');
		}
		
		if ($this->image->delete($image_id)) {
			unlink('./uploads/'.$image_name);
			unlink('./uploads/thumbnail/'.$image_name);
			$this->session->set_flashdata('success','City cover photo is successfully deleted.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('cities/edit/' . $city_id));
	}
	
	function delete_city($city_id)
	{
		if ( ! $this->session->userdata( 'is_city_admin' )) {
		    $this->check_access('delete');
		}

		// city images		
		$city_images = $this->image->get_all_by_type( $city_id, 'city' );
		foreach ( $city_images->result() as $img ) {
			if ( $this->image->delete( $img->id )) {
				@unlink('./uploads/'.$img->path);		
			}
		}

		// category images
		$categories = $this->category->get_all($city_id)->result();
		foreach ( $categories  as $category ) {
			$cat_imgs = $this->image->get_all_by_type( $category->id, 'category' )->result();
			foreach ( $cat_imgs as $img ) {
				if ($this->image->delete($img->id)) {
					@unlink('./uploads/'.$img->path);	
				}
			}
		}

		// sub_category images
		$sub_categories = $this->sub_category->get_all( $city_id )->result();
		foreach ( $sub_categories as $sub_category ) {
			$sub_cat_imgs = $this->image->get_all_by_type( $sub_category->id, 'sub_category' )->result();
			foreach ( $sub_cat_imgs as $img ) {
				if ($this->image->delete($img->id)) {
					@unlink('./uploads/'.$img->path);	
				}
			}
		}
		
		// item images
		$items = $this->item->get_all( $city_id )->result();
		foreach ( $items as $item ) {
			$item_imgs = $this->image->get_all_by_type( $item->id, 'item' )->result();
			foreach ( $item_imgs as $img ) {
				if ($this->image->delete($img->id)) {
					@unlink('./uploads/'.$img->path);	
				}
			}
		}
		
		// feed images
		$feeds = $this->feed->get_all( $city_id )->result();
		$feed_arr = array();
		foreach ( $feeds as $feed ) {
			$feed_imgs = $this->image->get_all_by_type( $feed->id, 'feed' )->result();
			foreach ( $feed_imgs as $img ) {
				if ($this->image->delete($img->id)) {
					@unlink('./uploads/'.$img->path);	
				}
			}
		}
		
		// categories
		$this->category->delete_by_city( $city_id );

		// favourites
		$this->favourite->delete_by_city( $city_id );

		// feeds
		$this->feed->delete_by_city( $city_id );

		// likes
		$this->like->delete_by_city( $city_id );

		// reviews
		$this->review->delete_by_city( $city_id );

		// cities
		$this->city->delete_by_city( $city_id );

		// follows
		$this->follow->delete_by_city( $city_id );

		// subcategories
		$this->sub_category->delete_by_city( $city_id );

		// touches
		$this->touch->delete_by_city( $city_id );

		// items
		$this->item->delete_by_city( $city_id );

		// inquiries
		$this->inquiry->delete_by_city( $city_id );
		
		// ratings
		$this->rating->delete_by_city( $city_id );
		
		$this->session->set_flashdata('success','City is successfully deleted.');
		redirect(site_url('cities'));
	}
	
	function email_to_user( $to = false, $is_approved = true )
	{
		// if there is no receptient email
		if ( ! $to ) return false;

		// get email configuration
		$sender_email = $this->config->item( 'sender_email' );
		$sender_name = $this->config->item( 'sender_name' );

		// prepare subject and message
		$url = site_url();

		$action = "approved";
		if ( ! $is_approved ) {
			$action = "rejected";
		}

	   	$subject = 'You city has been '. $action;
		$html = <<<EOT
<p>Hi</p>

<p>Good day.</p>

<p>Your city has been $action.</p>
<a href='$url'>Go to City Directory</a>

<p>
	Best Regards,<br/>
	<em>Cities Directory</em>
<p>
EOT;
	
		// configure email		
		$this->email->from( $sender_email, $sender_name );
		$this->email->to( $to ); 
		$this->email->subject( $subject );
		$this->email->message( $html );	

		// send email
		if ( ! $this->email->send() ) {
			return false;
		}

		return true;
	}

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
	            'token' => $token, 								// Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
	            'payerid' => $payer_id,
	            'surveyquestion' => ''
            );
	        
        } else {
        	$fields = array(
	            'returnurl' => site_url( 'cities/do_express_checkout_payment/'. $city_data['id'] ), 							// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
	            'cancelurl' => site_url( 'cities/do_express_checkout_payment/'. $city_data['id'] ),
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
            $this->session->set_flashdata( 'error', 'Error occured in paypal transaction. Contact system administrator' );

        } else {

        	if ( $PayPalResult['PAYMENTINFO_0_ACK'] != 'Success' ) {
        		$this->session->set_flashdata( 'error', 'Error occured in paypal transaction');
        		redirect(site_url('cities/create'));
        	}

        	$city_data = array( 'paypal_trans_id' => $PayPalResult['PAYMENTINFO_0_TRANSACTIONID'] );

        	if ( ! $this->city->save( $city_data, $city_id )) {
        		$this->session->set_flashdata( 'error', 'Error occured in paypal transaction');
        		redirect(site_url('cities/create'));
        	}

        	$this->session->set_flashdata( 'success', 'Congratulation! New City has been created' );
            // Successful call.  Load view or whatever you need to do here.
        }

		redirect(site_url('cities/create'));
    }
}
?>