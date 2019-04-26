<?php
class Citiesdirectory extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

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

        if ( isset( $_GET['url'] )) {
            // if source url is existed, that url need to be redirected after login

            $this->session->set_userdata( 'source_url', $_GET['url'] );
        }
    }

    /**
     * Checks the user credential and redirect to respecitve urls
     *
     */
    function login()
    {
        if ( $this->user->is_logged_in() ) {

            // if the user is already logged in, redirect to respective url
            $this->redirect_url();

        } else {

            // if the user is not yet logged in, authenticate url or load the login form view
            if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

                // if request is post method, login and redirect
                $user_email = htmlentities($this->input->post('user_email'));
                $user_password = $this->input->post('user_pass');

                if ( ! filter_var( $user_email, FILTER_VALIDATE_EMAIL )) {
                    // if the email input is invalid email address

                    // find the related email with that username
                    $emails = $this->user->get_info_by_username( $user_email )->result();

                    if ( empty( $emails )) {
                        // if there is no related email
                        $this->session->set_flashdata('error','Username does not exist');
                        redirect(site_url('login'));
                    }

                    // create error mesage with such email list
                    $error = "You can no longer log in with a username. Use your email address instead. <br/>";
                    foreach ( $emails as $email ) {
                        $error .= $email->user_email ."<br>";
                    }

                    $this->session->set_flashdata( 'error', $error );
                    redirect(site_url('login'));
                }

                if ( $this->user->login( $user_email, $user_password )) {

                    // if credential is correct, redirect to respective url
                    $this->redirect_url();

                } else {

                    // if credential is incorrect, show error message and redirect to login
                    $this->session->set_flashdata('error','Username and password do not match.');
                    redirect(site_url('login'));
                }
            } else {

                // if request is GET method, load login form
                $this->load->view('login');
            }
        }
    }

    /**
     * redirects to the respective urls based on user action
     *
     */
    function redirect_url()
    {
        /* different urls based on user credential */
        $admin_url = site_url( 'admin' );
        $login_url = site_url( 'login ');
        $frontend_url = site_url( 'Home' );

        if ( null !== $this->session->userdata( 'source_url' )) {
            // if coming from existing url

            $source_url = $this->session->userdata( 'source_url' );
            $this->session->unset_userdata( 'source_url' );
            redirect( $source_url );

        } else if ( !$this->user->is_logged_in() ) {
            // if user is not yet logged in, redirect to login

            redirect( $login_url );
        } else if ( $this->user->is_frontend_user() ) {
            // if the logged in user is frontend user,

            redirect( $frontend_url );
        } else if ( $this->user->is_system_user() ) {
            // if the logged in user is system user, redirect to admin

            redirect( $admin_url );
        } else {
            // if the logged in user is not frontend user, redirect to dashbaord

            $this->goto_approved_cities();
        }
    }

    /**
     * finds the approved cities and redirect to dashbaord of the first city
     *
     */
    function goto_approved_cities()
    {
        /* user info to find the cities */
        $conds = array(
            'admin_id' => $this->user->get_logged_in_user_info()->user_id,
            'is_approved' => 1
        );

        /* find the approved cities and redirect */
        $approved_cities = $this->city->get_all_by( $conds )->result();

        if ( count( $approved_cities ) == 0 ){

            // if no approved cities, show error message and redirect to login
            $this->user->logout();

            $this->session->set_flashdata('error', 'You could not login to system because your registered City is not yet approve' );

            redirect( site_url( 'login' ));
        } else {

            // if approved cities exist, redirect to the dashboard of the first city
            redirect(site_url( "/dashboard/index/" . $approved_cities[0]->id ));
        }
    }

    function logout()
    {
        $this->user->logout();
        $this->redirect_url();
    }

    function reset($code = false)
    {
        if (!$code || !$this->code->exists(array('code'=>$code))) {
            redirect(site_url('login'));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = $this->code->get_by_code($code);
            if ($code->is_systemuser == 1) {
                $data = array(
                    'user_pass' => md5($this->input->post('password'))
                );
                if ($this->user->update_profile($data,$code->user_id)) {
                    $this->code->delete($code->user_id);
                    $this->session->set_flashdata('success','Password is successfully reset.');
                    redirect(site_url('login'));
                }
            } else {
                $data = array(
                    'password' => md5($this->input->post('password'))
                );
                if ($this->appuser->save($data,$code->user_id)) {
                    $this->code->delete($code->user_id);
                    $this->session->set_flashdata('success','Password is successfully reset.');
                    redirect(site_url('login'));
                }
            }
        }

        $data['code'] = $code;
        $this->load->view('reset/reset',$data);
    }

    function forgot()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = htmlentities($this->input->post('user_email'));
            $user = $this->user->get_info_by_email($email);

            if ($user->user_id == "") {
                $this->session->set_flashdata('error','Email does not exist in the system.');
            } else {
                $code = md5(time().'teamps');
                $data = array(
                    'user_id'=>$user->user_id,
                    'code'=> $code,
                    'is_systemuser'=>1
                );
                if ($this->code->save($data,$user->user_id)) {
                    $sender_email = $this->config->item('sender_email');
                    $sender_name = $this->config->item('sender_name');
                    $to = $user->user_email;
                    $subject = 'Password Reset';
                    $html = "<p>Hi,".$user->user_name."</p>".
                        "<p>Please click the following link to reset your password<br/>".
                        "<a href='".site_url('reset/'.$code)."'>Reset Password</a></p>".
                        "<p>Best Regards,<br/>".$sender_name."</p>";

                    $this->email->from($sender_email,$sender_name);
                    $this->email->to($to);
                    $this->email->subject($subject);
                    $this->email->message($html);
                    $this->email->send();

                    $this->session->set_flashdata('success','Password reset email already sent!');
                    redirect(site_url('login'));
                } else {
                    $this->session->set_flashdata('error','System error occured. Please contact your system administrator.');
                }
            }
        }

        $this->load->view('reset/forgot');
    }

    function create_city()
    {
        if ( $this->user->is_logged_in() ) {
            redirect(site_url() . '/admin');
        }

        if ( $this->input->server('REQUEST_METHOD') == 'POST' ) {

            $upload_data = $this->uploader->upload($_FILES);

            if ( ! isset( $upload_data['error'] )) {

                $city_data = $this->input->post();

                $temp = array();
                foreach ( $city_data as $key => $value ) {
                    $temp[$key] = htmlentities($value);
                }
                $city_data = $temp;

                $user_pass = $city_data['user_password'];
                $img_desc = $city_data['image_desc'];

                #----------------------------------------
                # save user data
                #----------------------------------------
                // prepare user data
                $user_data = array(
                    'user_name' => $city_data['user_name'],
                    'user_email' => $city_data['user_email'],
                    'user_pass' => md5( $city_data['user_password']),
                    'is_city_admin' => "1",
                    'role_id' => 4
                );

                // prepare permision for new register user
                $permissions = array();
                foreach ( $this->module->get_all()->result() as $module ) {
                    if ( $module->module_name != "users" ) {
                        $permissions[] = $module->module_id;
                    }
                }

                // save user data
                if ( ! $this->user->save( $user_data, $permissions )) {
                    $this->session->set_flashdata( 'error', 'Database error occured in create new city');
                    redirect( site_url( 'login' ));
                }

                #----------------------------------------
                # save city data
                #----------------------------------------
                // prepare data
                unset($city_data['user_name']);
                unset($city_data['user_email']);
                unset($city_data['user_password']);
                unset($city_data['conf_password']);
                unset($city_data['image_desc']);
                unset($city_data['images']);

                $city_data['is_approved'] = 0;

                $city_data['admin_id'] = $user_data['user_id'];

                // save data
                if ( ! $this->city->save( $city_data )) {
                    $this->session->set_flashdata( 'error', 'Database error occured in logging in to system');
                    redirect( site_url( 'login' ));
                }

                #----------------------------------------
                # save cover photo data
                #----------------------------------------
                foreach ( $upload_data as $upload ) {
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

                #----------------------------------------
                # send email to administrator
                #----------------------------------------
                if ( ! $this->email_to_admin() ) {
                    $this->session->set_flashdata( 'error', 'Error occured in email sending');
                    redirect( site_url( 'login' ));
                }

                #----------------------------------------
                # do paypal transaction
                #----------------------------------------

                if ( $this->paypal_config->is_paypal_enable()) {
                    if ( ! $this->set_express_checkout( $city_data )) {
                        $this->session->set_flashdata( 'error', 'Error occured in paypal transaction');
                        redirect( site_url( 'login' ));
                    }
                }


                //$this->session->set_flashdata( 'success', 'Congratulation! Your City has been registered' );
                $this->load->view( 'message' );
                return;
            } else {
                $data['error'] = $upload_data['error'];
            }
        }

        $this->load->view( 'create_city' );

    }

    //is exist
    function exists($user_id=null)
    {
        $user_name = $_REQUEST['user_name'];

        if (strtolower($this->user->get_info($user_id)->user_name) == strtolower($user_name)) {
            echo "true";
        } else if($this->user->exists(array('user_name'=>$_REQUEST['user_name']))) {
            echo "false";
        } else {
            echo "true";
        }
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
                'returnurl' => site_url( 'citiesdirectory/do_express_checkout_payment/'. $city_data['id'] ), 							// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
                'cancelurl' => site_url( 'citiesdirectory/do_express_checkout_payment/'. $city_data['id'] ),
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
                redirect(site_url('login'));
            }

            $city_data = array( 'paypal_trans_id' => $PayPalResult['PAYMENTINFO_0_TRANSACTIONID'] );

            if ( ! $this->city->save( $city_data, $city_id )) {
                $this->session->set_flashdata( 'error', 'Error occured in paypal transaction');
                redirect(site_url('login'));
            }

            //$this->session->set_flashdata( 'success', 'Congratulation! New City has been created' );
            // Successful call.  Load view or whatever you need to do here.
            $this->load->view( 'message' );
            return;
        }

        redirect( site_url( 'login' ));
    }

    /**
     * creates app users
     */
    function create_user()
    {
        if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
            // only post method is allowed here

            echo "only POST method is allowed";
            return;
        }

        // get varaibles
        $user_name = htmlentities( $this->input->post( 'signupName' ));
        $user_password = htmlentities( $this->input->post( 'signupPass' ));
        $user_email = htmlentities( $this->input->post( 'signupEmail' ));

        // prepare user data
        $user_data = array(
            'username' => $user_name,
            'password' => md5( $user_password ),
            'email' => $user_email,
            'profile_photo' => 'default_user_profile.png'
        );

        if ( $this->appuser->save( $user_data )) {
            // if no error in saving app user data, login to system

            if ( $this->user->login( $user_email, $user_password )) {
                // if no error in logged in to the system, redirect to previous url

                $this->redirect_url();
            } else {
                // if error in logged in, go to login page

                $this->session->set_flashdata( 'error', 'error occured in logged in to the system' );
                redirect( site_url( 'login' ));
            }

        } else {
            // if error in creating app user, redirect to the previous url

            $this->session->set_flashdata( 'error', 'Error occured in creating app user');
            redirect(site_url('login'));
        }
    }

    /**
     * checks if email is already registered
     */
    function is_email_exists()
    {
        // get variables
        $email = htmlentities($_REQUEST['signupEmail']);

        // prep cond array
        $appuser_conds = array( 'email' => $email );
        $beuser_conds = array( 'user_email' => $email );

        if ( $this->appuser->exists( $appuser_conds )) {
            // if email address exists in app user table, return true
            echo "false";
        } else if ( $this->user->exists( $beuser_conds )) {
            // if email address exists in be user table, return false
            echo "false";
        } else {
            // return true
            echo "true";
        }
    }
}
?>