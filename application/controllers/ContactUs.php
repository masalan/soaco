<?php
/**
 * Front End Item Filters Page Controller
 * 
 */
include_once( APPPATH .'controllers/Main.php' );

class ContactUs extends Main
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
		$this->data['page_id'] = 'contact-us';
        
        // load email library
		$this->load->library('email',array(
			'mailtype'  => 'html',
			'newline'   => '\r\n'
		));
	}

	/**
	 * About Us Main Function
	 */
	function index()
	{
		/* Get About Us Info */
		$about = $this->about->get_all()->result();
		if ( !empty( $about )) {
			$this->data['about'] = $about[0];
		}

		/* Load views */
		//$this->data['contactus_cover'] = true;
		$this->load->view( $this->theme .'header', $this->data );
		$this->load->view( $this->theme .'nav' );
		$this->load->view( $this->theme .'contact-us' );
		$this->load->view( $this->theme .'footer' );
	}

	function contact()
	{
		$contact_data = array(
			'name' => htmlentities( $_REQUEST['name'] ),
			'email' => htmlentities( $_REQUEST['email'] ),
			'phone' => htmlentities( $_REQUEST['phone'] ),
			'website' => htmlentities( $_REQUEST['website'] ),
			'subject' => htmlentities( $_REQUEST['subject'] ),
			'message' => htmlentities( $_REQUEST['message'] ),
			'recipient' => htmlentities( $_REQUEST['recipient'] )
		);

		if ( $this->email_to_admin( $contact_data )) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/**
     * emails to admin
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    function email_to_admin( $contact_data )
	{
		// get email configuration
		$sender_email = $this->config->item( 'sender_email' );
		$sender_name = $this->config->item( 'sender_name' );
		//$admin_email = $this->config->item( 'admin_email' );
		$admin_email = $contact_data['recipient'];

		// prepare subject and message
		$url = site_url();
	   	$subject = 'New Contact from Cities Directory App';

		$html = "<p>From:". $contact_data['name'] ."</p>";

		$html .= "<p>Email:". $contact_data['email'] ."</p>";

		if ( !empty( $contact_data['phone'] ))
			$html .= "<p>Phone:". $contact_data['phone'] ."</p>";

		if ( !empty( $contact_data['website'] ))
			$html .= "<p>Website:". $contact_data['website'] ."</p>";

		$html .= "<p>Message:". $contact_data['message'] ."</p>";
		$html .="
			<p>
				Best Regards,<br/>
				<em>Cities Directory</em>
				This email was sent from a contact form on CitiesDirectory
			<p>
		";
	
		// configure email		
		$this->email->from($sender_email,$sender_name);
		$this->email->to($admin_email); 
		$this->email->subject($subject);
		$this->email->message($html);	

		// send email
		if ( ! $this->email->send()) {

			$this->session->set_flashdata( 'error', 'Error occured in email sending');
			return false;
		}

		return true;
	}
}