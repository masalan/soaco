<?php  
class Code extends Base_Model
{
	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "cd_codes";
	}

	function exists($data)
	{
		$this->db->from($this->table_name);
		
		if (isset($data['code'])) {
			$this->db->where('code',$data['code']);
		}
		
		if (isset($data['user_id'])) {
			$this->db->where('user_id',$data['user_id']);
		}
		
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	function save(&$data,$user_id=false)
	{
		if (!!$user_id && !$this->exists(array('user_id'=>$user_id))) {
			if ($this->db->insert($this->table_name,$data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			$this->db->where('user_id',$user_id);
			return $this->db->update($this->table_name,$data);
		}
		
		return false;
	}

	function get_by_code($code)
	{
		$query = $this->db->get_where($this->table_name,array('code'=>$code));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

	function delete($user_id)
	{
		$this->db->where('user_id',$user_id);
		return $this->db->delete($this->table_name);
	}


	/*************************** RAVITAILLEMENT ***********************************/

    function save_ravit_code(&$data)
    {
        if ($this->db->insert('cd_ravit_tempo',$data)) {
            $data['id'] = $this->db->insert_id();
            return true;
        }
    }


    function exists_code($data)
    {
        $this->db->from('cd_ravit_tempo');

        if (isset($data['code'])) {
            $this->db->where('code',$data['code']);
        }

        if (isset($data['user_id'])) {
            $this->db->where('user_id',$data['user_id']);
        }

        $query = $this->db->get();
        return ($query->num_rows()==1);
    }

    function get_code($code)
    {
        $query = $this->db->get_where('cd_ravit_tempo',array('code'=>$code));

        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object('cd_ravit_tempo');
        }
    }


    /******************************************* Check coupons ************************************************/

    function get_paiement_by($code)
    {
        $query = $this->db->get_where('type_pay',array('id'=>$code));

        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object('type_pay');
        }
    }

    function check_coupon($code)
    {
        $query = $this->db->get_where('cd_cards',array('card_serial'=>$code));

        if ($query->num_rows()==1) {
            return $query->row();
        } else {
            return $this->get_empty_object('cd_cards');
        }
    }



    /**
     * get_info return the user object according to the user_id
     *
     * @param int user_id
     * @return user object
     */
    function get_info_by_code($code)
    {
        $this->db->from('cd_ravit_tempo');
        $this->db->where( 'code', $code );
        return $this->db->get();
    }


    function update_tempo($data, $code)
    {
        $this->db->where('code',$code);
        $success = $this->db->update('cd_ravit_tempo',$data);

        return $success;
    }



    /*************************** SMS TWILIO ***********************************/

    //COMMON FUNCTION FOR SENDING SMS
    function sms_send($message = '' , $reciever_phone = '')
    {
        $this->send_sms_via_clickatell($message , $reciever_phone );

        /****
        $active_sms_service = $this->db->get_where('settings' , array(
            'type' => 'active_sms_service'
        ))->row()->description;
        if ($active_sms_service == '' || $active_sms_service == 'disabled')
            return;

        if ($active_sms_service == 'clickatell') {
            $this->send_sms_via_clickatell($message , $reciever_phone );
        }
        if ($active_sms_service == 'twilio') {
            $this->send_sms_via_twilio($message , $reciever_phone );
        }
        if ($active_sms_service == 'msg91') {
            $this->send_sms_via_msg91($message , $reciever_phone );
        }
        ****/
    }

    // SEND SMS VIA CLICKATELL API
    function send_sms_via_clickatell($message = '' , $reciever_phone = '') {

        $clickatell_user       = 'mussiruserge@gmail.com';// $this->db->get_where('settings', array('type' => 'clickatell_user'))->row()->description;
        $clickatell_password   = 'mussiruserge1984'; // $this->db->get_where('settings', array('type' => 'clickatell_password'))->row()->description;
        $clickatell_api_id     = 'hzrVITPPQGisIFJ1lvDKBg=='; // $this->db->get_where('settings', array('type' => 'clickatell_api_id'))->row()->description;
        $clickatell_baseurl    = "https://api.clickatell.com";

        $text   = urlencode($message);
        $to     = $reciever_phone;

        // auth call
        $url = "$clickatell_baseurl/http/auth?user=$clickatell_user&password=$clickatell_password&api_id=$clickatell_api_id";
     //  https://api.clickatell.com/http/auth?user=$clickatell_user&password=$clickatell_password&api_id=$clickatell_api_id
     //   curl "https://platform.clickatell.com/messages/http/send?apiKey=hzrVITPPQGisIFJ1lvDKBg==&to=22967750250&content=Votre code de securite"
        // https://api.clickatell.com/http/auth?"+ "user=$username&password=$password&api_id=$api_id


        // do auth call
        $ret = file($url);

        // explode our response. return string is on first line of the data returned
        $sess = explode(":",$ret[0]);
        print_r($sess);echo '<br>';
        if ($sess[0] == "OK") {
            $sess_id = trim($sess[1]); // remove any whitespace
         // $url = "$clickatell_baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
            $url = "$clickatell_baseurl/messages/http/send?apiKey$sess_id&to=$to&content=$text";
            // do sendmsg call
            $ret = file($url);
            $send = explode(":",$ret[0]);
            print_r($send);echo '<br>';
            if ($send[0] == "ID") {
                echo "successnmessage ID: ". $send[1];
            } else {
                echo "échec d'envoi du code par SMS";
            }
        } else {
            echo "Échec de l'authentification: ". $ret[0];
        }
    }


    // SEND SMS VIA TWILIO API
    function send_sms_via_twilio($message = '' , $reciever_phone = '') {

        // LOAD TWILIO LIBRARY
        require_once(APPPATH . 'libraries/twilio_library/Twilio.php');


        $account_sid    = 'AC2a0d617fb2b1052d3ea8c7bac0780b16'; //$this->db->get_where('settings', array('type' => 'twilio_account_sid'))->row()->description;
        $auth_token     = 'c538645d40a31f7ee39c4d7269aea735'; // $this->db->get_where('settings', array('type' => 'twilio_auth_token'))->row()->description;
        $client         = new Services_Twilio($account_sid, $auth_token);

        $client->account->messages->create(array(
            'To'        => $reciever_phone,
            'From'      => $this->db->get_where('settings', array('type' => 'twilio_sender_phone_number'))->row()->description,
            'Body'      => $message
        ));

    }

    //SMS via msg91
    function send_sms_via_msg91($message = '' , $reciever_phone = '') {

        $authKey       = $this->db->get_where('settings', array('type' => 'msg91_authentication_key'))->row()->description;
        $senderId      = $this->db->get_where('settings', array('type' => 'msg91_sender_ID'))->row()->description;
        $country_code  = $this->db->get_where('settings', array('type' => 'msg91_country_code'))->row()->description;
        $route         = $this->db->get_where('settings', array('type' => 'msg91_route'))->row()->description;

        //Multiple mobiles numbers separated by comma
        $mobileNumber = $reciever_phone;

        //Your message to send, Add URL encoding here.
        $message = urlencode($message);

        //Prepare you post parameters
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route,
            'country' => $country_code
        );
        //API URL
        $url="http://api.msg91.com/api/sendhttp.php";

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
    }




}
?>