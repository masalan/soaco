<?php
require_once('Main.php');

class gcm extends Main 
{
	function __construct() 
	{
		parent::__construct("gcm");
	}

	function index() 
	{
		if ( $this->input->server( 'REQUEST_METHOD' ) == "POST" ) {
			$message = htmlentities($this->input->post( 'message' ));

			$devices = $this->gcm_token->get_all()->result();;

			$reg_ids = array();
			if ( count( $devices ) > 0 ) {
				foreach ( $devices as $device ) {
					$reg_ids[] = $device->reg_id;
				}
			}

			$status = $this->sendMessageThroughGCM( $reg_ids, array( "m" => $message ));

			$this->session->set_flashdata( 'success', "Successfully Sent Push Notification" );

			redirect( 'gcm' );
		}

		$content['content'] = $this->load->view( 'gcm/form', array(), true );
		
		$this->load_template($content, false);
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

}

?>