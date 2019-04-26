<?php
class Citiesdirectory extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");


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

    function login_11()
    {
        $data['page_title'] = 'SOACO e-Station | Connexion a ma Station';
        if ( $this->is_logged_in() ) {
            // if the user is already logged in, redirect to respective url
            $this->redirect_url();

        } else {
            if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
                // if request is post method, login and redirect
                $pseudo = htmlentities($this->input->post('pseudo'));
                $password = $this->input->post('password');

                if ($this->get_login($pseudo,$password)) {
                    // dependant de la valeur ID Role
                    $this->redirect_url();
                } else {
                    // if credential is incorrect, show error message and redirect to login
                    $this->session->set_flashdata('error','Connexion refusée. Nom de compte ou mot de passe incorrect');
                    redirect(site_url('station'));
                }
            } else {
                // if request is GET method, load login form
                $this->load->view('login_station',$data);
            }
        }
    }


    function redirect_url() {

        $admin_url = site_url('soaco' );
        $desk_url = site_url('soaco_e-Station' );

        $conds = array(
            'admin_id' => $this->user->get_logged_in_user_info()->user_id,
            'is_approved' => 1
        );
        /* find the approved Dpt and redirect */
        $approved_cities = $this->city->get_all_by( $conds )->result();

        if ($this->session->userdata('role_id') == 1)
            redirect($admin_url);
        if ($this->session->userdata('role_id') == 2)
            redirect(site_url( "/manager/" . url_encode($approved_cities[0]->id)));

        if ($this->session->userdata('role_id') == 3)
            redirect(site_url( "/manager/" . url_encode($approved_cities[0]->id)));

        if ($this->session->userdata('role_id') == 4)
            redirect(site_url( "/manager/" . url_encode($approved_cities[0]->id)));

        if ($this->session->userdata('role_id') == 5)
            redirect($desk_url);  // Station

        if ($this->session->userdata('role_id') == 6)
            redirect($desk_url);  // Station
        $this->load->view('login_station');
    }





    function logout()
    {
        $this->station_logout();
        redirect(site_url('station'));
    }

    function reset($code = false)
    {
        if (!$code || !$this->code->exists(array('code'=>$code))) {
            redirect(site_url('station'));
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
                    redirect(site_url('station'));
                }
            } else {
                $data = array(
                    'password' => md5($this->input->post('password'))
                );
                if ($this->appuser->save($data,$code->user_id)) {
                    $this->code->delete($code->user_id);
                    $this->session->set_flashdata('success','Password is successfully reset.');
                    redirect(site_url('station'));
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
                $this->session->set_flashdata('error','Votre e-mail n\'existe pas dans le système SOACO e-Station.');
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
                    $subject = 'Réinitialisation de mot de passe';
                    $html = "<p>Salut,".$user->user_name."</p>".
                        "<p>S'il vous plaît cliquez sur le lien suivant pour réinitialiser votre mot de passe<br/>".
                        "<a href='".site_url('reset/'.$code)."'>Réinitialiser maintenanat</a></p>".
                        "<p>Cordial Salutation,<br/>".$sender_name."</p>";

                    $this->email->from($sender_email,$sender_name);
                    $this->email->to($to);
                    $this->email->subject($subject);
                    $this->email->message($html);
                    $this->email->send();

                    $this->session->set_flashdata('success','Email de réinitialisation de mot de passe à été déjà envoyé!');
                    redirect(site_url('station'));
                } else {
                    $this->session->set_flashdata('error','Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
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
                    redirect(site_url('station'));
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
                    redirect(site_url('station'));
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
                    redirect(site_url('station'));
                }

                #----------------------------------------
                # do paypal transaction
                #----------------------------------------

                if ( $this->paypal_config->is_paypal_enable()) {
                    if ( ! $this->set_express_checkout( $city_data )) {
                        $this->session->set_flashdata( 'error', 'Error occured in paypal transaction');
                        redirect(site_url('station'));
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
                'returnurl' => site_url( 'theme/do_express_checkout_payment/'. $city_data['id'] ), 							// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
                'cancelurl' => site_url( 'theme/do_express_checkout_payment/'. $city_data['id'] ),
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
                redirect(site_url('station'));
            }

            $city_data = array( 'paypal_trans_id' => $PayPalResult['PAYMENTINFO_0_TRANSACTIONID'] );

            if ( ! $this->city->save( $city_data, $city_id )) {
                $this->session->set_flashdata( 'error', 'Error occured in paypal transaction');
                redirect(site_url('station'));
            }

            //$this->session->set_flashdata( 'success', 'Congratulation! New City has been created' );
            // Successful call.  Load view or whatever you need to do here.
            $this->load->view( 'message' );
            return;
        }

        redirect(site_url('station'));
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

            if ( $this->get_login( $user_email, $user_password )) {
                // if no error in logged in to the system, redirect to previous url

                $this->redirect_url();
            } else {
                // if error in logged in, go to login page

                $this->session->set_flashdata( 'error', 'error occured in logged in to the system' );
                redirect(site_url('station'));
            }

        } else {
            // if error in creating app user, redirect to the previous url

            $this->session->set_flashdata( 'error', 'Error occured in creating app user');
            redirect(site_url('station'));
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


    /************************************************************************ My Model*********************************************************************************************************************************
     *********************************************************************************************************************************************************************************************************************/

    function login_good($pseudo, $user_pass) {
        $this->db->select('id as user_id, user_name, email, password');
        $this->db->from('users');
        $this->db->where('email', $this->_userName);
        $this->db->where('verification_code', 1);
        $this->db->where('status', 1);
        //{OR}
        $this->db->or_where('user_name', $this->_userName);
        $this->db->where('verification_code', 1);
        $this->db->where('status', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verifyHash($this->_password, $row->password) == TRUE) {
                    return $result;
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    function get_login($pseudo, $user_pass)
    {
        /* FIND USER IN SYSTEM USER TABLE */
        $is_frontend_user = false;

        $conds = array('user_name' => $pseudo, 'user_pass' => md5($user_pass), 'status' => 1);
        $query = $this->db->get_where('be_users', $conds,1);
        if ($query->num_rows() == 0 ) {
            return false;
        }


        $row = $query->row();
        /* SYSTEM USER AND CITY ADMIN INFORMATION */
        $user_id = ( $is_frontend_user )? $row->id: $row->user_id;
        $is_owner = ( $is_frontend_user )? 0: $row->is_owner;
        $role_id = ( $is_frontend_user )? 0: $row->role_id;
        $station_id = ($is_frontend_user )? 0: $row->station_id;   // Station ID
        $fullname = ( $is_frontend_user )? $row->id: $row->fullname;
        $profile_photo = ($is_frontend_user )? $row->profile_photo: $row->profile_photo;
        $phone = ($is_frontend_user )? $row->phone: $row->phone;
        $user_name = ( $is_frontend_user )? $row->user_name: $row->user_name;

        $allow_city_id = 0;
        $is_city_admin = 0;

        /* CITY ADMIN INFORMATION */
        if ( !$is_frontend_user ) {
            if ( $row->is_city_admin ) {
                // get the city that user can manager
                $city_query = $this->db->get_where( 'cd_cities', array( 'admin_id' => $row->user_id ));

                $city_id = 0;

                if ( $city_query->num_rows() > 0 ) {
                    $city = $city_query->row();
                    $city_id = $city->id;
                }

                $allow_city_id = $city_id;
                $is_city_admin = true;
            }
        }

        /* SESSION VARIABLES */
        $this->session->set_userdata( 'user_id', $user_id );
        $this->session->set_userdata( 'is_owner', $is_owner );
        $this->session->set_userdata( 'role_id', $role_id );
        $this->session->set_userdata( 'allow_city_id', $allow_city_id );
        $this->session->set_userdata( 'is_city_admin', $is_city_admin );
        $this->session->set_userdata( 'station_id', $station_id);
        $this->session->set_userdata( 'fullname', $fullname );
        $this->session->set_userdata( 'profile_photo', $profile_photo );
        $this->session->set_userdata( 'phone', $phone );
        $this->session->set_userdata( 'user_name', $user_name );


        return true;
    }



    function  station_logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('station'));
        $this->session->unset_userdata( 'user_id');
        $this->session->unset_userdata( 'is_owner');
        $this->session->unset_userdata( 'role_id');
        $this->session->unset_userdata( 'allow_city_id');
        $this->session->unset_userdata( 'is_city_admin');
        $this->session->unset_userdata( 'is_frontend_user' );

    }

    function is_logged_in()
    {
        return $this->session->userdata('user_id')!=false;
    }

    function is_frontend_user()
    {
        return ($this->session->userdata('is_frontend_user'));
    }

    function is_system_user()
    {
        return ($this->session->userdata('role_id') != 4);
    }









}
?>