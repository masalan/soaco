<?php
require_once('Main.php');
use libraries\twilio_library\Twilio\Rest\Client;

class Ravit extends Main
{
    function __construct()
    {
        parent::__construct( NO_ACCESS_CONTROL );
    }

    function index($data_id = 0)
    {
        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('stock'));
        }
        $data['secure_code']   = $this->item->get_secure_code($station_id,7,$this->uri->segment(3));

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));


        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;

        $data['societe'] = $this->user->get_one_company_info($company_id); // One company

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;


        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();



        $data['page_title'] = 'Gestion de stock | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/ravit',$data);
        $this->load->view('layout/themes/footer',$data);
    }



    function step1() {

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('stock'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));


        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;

        $data['societe'] = $this->user->get_one_company_info($company_id); // One company

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;


        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();


        $data['page_title'] = 'Gestion de stock | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/ravit1',$data);
        $this->load->view('layout/themes/footer',$data);
    }



    function step2() {

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('stock'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));


        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;

        $data['societe'] = $this->user->get_one_company_info($company_id); // One company

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;


        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();


        $data['secure_code']   = $this->item->get_secure_code($station_id,7,$this->uri->segment(3));;

        $data['page_title'] = 'Gestion de stock | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/ravit2',$data);
        $this->load->view('layout/themes/footer',$data);
    }


    /**
     * Add quantity of Fuel
     */
    function step3() {

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('stock'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));

        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;

        $data['societe'] = $this->user->get_one_company_info($company_id); // One company

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;

        session_start();
        if (isset($_SESSION['code'])) {
            $code['code']  = $_SESSION['code'];
            $data['code'] = $this->code->get_code($code['code'] );
        }

        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();

        $data['secure_code']   = $this->item->get_secure_code($station_id,7,$this->uri->segment(3));;


        $data['page_title'] = 'Gestion de stock | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/final',$data);
        $this->load->view('layout/themes/footer',$data);
    }





    function step4() {

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('stock'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;

        session_start();
        if (isset($_SESSION['code'])) {
            $code['code']  = $_SESSION['code'];
            $data['code']  = $this->code->get_code($code['code']);
        }

        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;
        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();

        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $data['societe'] = $this->user->get_one_company_info($company_id); // One company



        $data['page_title'] = 'Gestion de stock | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/done',$data);
        $this->load->view('layout/themes/footer',$data);
    }

    /**
     *  Creation du code
     * De securite
     */
    function validate_data() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // $code = md5(time().'teamps');  // A revoir

            $this->load->helper('string');
            $code = random_string('alnum', 8);
            //$code =
            $data = array(
                'type' => htmlentities($this->input->post('type')),
                'company_deliver' => htmlentities($this->input->post('company_deliver')),
                'camion_number' => htmlentities($this->input->post('camion_number')),
                'created' => date("Y-m-d H:i:s"),
                'driver_name' => htmlentities($this->input->post('driver_name')),
                'driver_phone' => htmlentities($this->input->post('driver_phone')),
                'station_id' => htmlentities($this->input->post('station_id')),
                'user_id' => htmlentities($this->input->post('user_id')),
                'company_id' => htmlentities($this->input->post('company_id')),
                'code'=> $code,
                'is_valid'=>0,
                'country_id' => $this->session->userdata('country_id')

            );
            $message        = 'Votre code de securite est' . ' ' . $code . ' SOACO e-Sation.';
            $receiver_phone ='+22969669337'; // '+22969669337';

            if ($this->code->save_ravit_code($data)) {

                // Envois par SMS & E-mail
             //  $this->code->sms_send($message,$receiver_phone);
//                if ($this->code->sms_send($message,$receiver_phone)) {
//                    $this->session->set_flashdata( 'error', 'Error occured in email sending');
//                    redirect( site_url( 'produit/' ));
//                }


                $this->session->set_flashdata('success','Veuillez entrer le Code de sécurité que vous avez reçu');
            } else {
                redirect(site_url('produit/'), 'refresh');
                $this->session->set_flashdata('error','Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('code/'), 'refresh');
        }

        $data['page_title'] = 'Gestion de stock | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/ravit1',$data);
        $this->load->view('layout/themes/footer',$data);

    }

//     function sms_send2($msg,$receiver_phone) {
//         require_once(APPPATH . 'vendor/Twilio.php');
//
//         // Your Account SID and Auth Token from twilio.com/console
//        $sid = 'ACc7c1bde8cf82cb38302459cb41bb931b';
//        $token = '77472172e9971d5493c218fe2f9921f2';
//         $client = new vendor\Twilio\Rest\Client($sid, $token);
//         //$client = new client($sid, $token);
//
//         // $client = new Client($sid, $token);
//
//        // Use the client to do fun stuff like send text messages!
//        return $client->messages->create(
//        // the number you'd like to send the message to
//            $receiver_phone,
//            array(
//                // A Twilio phone number you purchased at twilio.com/console
//                "from" => "+22969669337",
//                // the body of the text message you'd like to send
//                'body' => $msg
//            )
//        );
//    }
//
//
//    function sms_send($message = '' , $reciever_phone = '') {
//
//        var_dump($message,$reciever_phone);
//        exit();
//        // LOAD TWILIO LIBRARY
//        require_once(APPPATH . 'vendor/Twilio.php');
//
//        $account_sid    = 'ACc7c1bde8cf82cb38302459cb41bb931b';
//        $auth_token     = '77472172e9971d5493c218fe2f9921f2';
//        $client         = new Services_Twilio($account_sid, $auth_token);
//
//        $client->account->messages->create(array(
//            'To'        => $reciever_phone,
//            'From'      => '+12028041874',
//            'Body'      => $message
//        ));
//
//    }
//
//
//
//
//



    /***
     * Verification du code
     * de securite
     * @param bool $code
     * http://soaco:8888/code/
     */

    function check_code()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $code = htmlentities($this->input->post('code'));

            $data = $this->code->get_code($code);

            if ($data->code == "") {

                $this->session->set_flashdata('error','Le Code de sécurité, que Vous avez rentrer n`existe pas, reessayer un autre.');

                redirect(site_url('code/'));

            }elseif ($data->is_valid == 1){

                $this->session->set_flashdata('error','Le Code de sécurité est invalide, reessayer un autre.');

                redirect(site_url('code/'));
            } else {
                if ($data->is_valid == 0) { $datas = array('is_valid' => 1, 'valid_date' => date('Y-m-d h:i:s'));

                    session_start();
                    $_SESSION['code']  = $data->code;
                    $_SESSION['is_valid'] = 1;  // 1  invalid

                    if ($this->code->update_tempo($datas,$code)) {
                        $this->session->set_flashdata('success','maintenant precisez la quantite et cliquer sur terminer');
                    }
                }
            }
            redirect(site_url('fini/').$code);
        }

        $data['code'] = $code;
        $data['page_title'] = 'Gestion de stock | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/final',$data);
        $this->load->view('layout/themes/footer',$data);

    }




    /**
     *  Ravitaillement
     * @param $data_id
     */
    function add_stock($station_id=0)
    {

        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $query    = $this->db->get_where('cd_items', array('id' => $station_id, 'is_published' => 1));  // Station fetch
            if ($query->num_rows() > 0) {
                $row           = $query->row();
                $city_id       = $row->city_id;
                $cat_id        = $row->cat_id;
                $sub_cat_id    = $row->sub_cat_id;
                $twon_id       = $row->twon_id;
                $company_id    = $row->company_id;
            }

            $initial_stock = $this->db->get_where('cd_fluid', array('type' => htmlentities($this->input->post('type')),'company_id' => htmlentities($this->input->post('company_id')),'station_id'=>$station_id))->row()->quantity?:0;
            $stock_actuel = $initial_stock + htmlentities($this->input->post('quantity'));

            $data = array(
                'device' => 'web',
                'station_id' => $station_id,
                'company_id' => $company_id,
                'quantity' => htmlentities($this->input->post('quantity')),
                'type' => htmlentities($this->input->post('type')),
                'date_stock' => date("Y-m-d H:i:s"),
                'name'=> htmlentities($this->input->post('name')),
                'departement_id'=> htmlentities($this->input->post('departement_id')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'type'=> htmlentities($this->input->post('type')),
                'prix'=> htmlentities($this->input->post('prix')),
                'country_id' => $this->session->userdata('country_id')
            );

            // historic des ravitaillement OK
            $data_log = array(
                'station_id'     => $station_id,
                'city_id'        => $city_id,
                'cat_id'         => $cat_id,
                'commune_id'     => $cat_id,
                'company_id'     => $company_id,
                'sub_cat_id'     => $sub_cat_id,
                'twon_id'        => $twon_id,
                'stock_initial'  => $initial_stock,
                'stock_actuel'   => $stock_actuel,
                'quantity'       => htmlentities($this->input->post('quantity')),
                'user_id'        => htmlentities($this->input->post('user_id')),
                'type'           => htmlentities($this->input->post('type')),
                'date_stock'     => date("Y-m-d H:i:s"),
                'user_id'        => htmlentities($this->input->post('user_id')),
                'country_id'     => $this->session->userdata('country_id'),
                'company_deliver'    => htmlentities($this->input->post('company_deliver')),
                'camion_number'      => htmlentities($this->input->post('camion_number')),
                'driver_name'        => htmlentities($this->input->post('driver_name')),
                'driver_phone'       => htmlentities($this->input->post('driver_phone')),
                'driver_number'      => htmlentities($this->input->post('driver_phone')),
                'code'               => htmlentities($this->input->post('code')),
                'name'               => htmlentities($this->input->post('name')),

            );

            // Ajout a la quantite existent ou Ajoute au tank vide
            if ($this->item->ravitaillement($data)) {  // OK

                  if (!$this->item->ravitaillement_log($data_log)) {

                    $this->session->set_flashdata('error', '1 Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                }

            } else {
                $this->session->set_flashdata('error', '2 A Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                redirect(site_url('stock/').url_encode($station_id));

            }
            redirect(site_url('felicitation/').url_encode($station_id));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_info($station_id); // One station
        $data['station_id'] = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence();
        $data['gasoil'] = $this->item->get_info_gasoil();
        $data['kerosene'] = $this->item->get_info_kerosene();
        $data['huile'] = $this->item->get_info_huile();

        $this->load->view('layout/themes/header',array());
        $this->load->view('layout/themes/nav',array());
        $this->load->view('desk/desk', $data);
        $this->load->view('layout/themes/footer',array());
    }


    /***
     * Add Stock gaz
     * @param int $station_id
     */
    function add_stock_gaz($station_id=0)
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $query    = $this->db->get_where('cd_items', array('id' => $station_id, 'is_published' => 1));  // Station fetch
            if ($query->num_rows() > 0) {
                $row           = $query->row();
                $city_id       = $row->city_id;
                $cat_id        = $row->cat_id;
                $sub_cat_id    = $row->sub_cat_id;
                $twon_id       = $row->twon_id;
                $company_id       = $row->company_id;
            }

            $initial_stock = $this->db->get_where('cd_fluid', array('type' => htmlentities($this->input->post('type')),'company_id' => htmlentities($this->input->post('company_id')),'station_id'=>$station_id))->row()->quantity;
            $stock_actuel = $initial_stock + htmlentities($this->input->post('quantity'));

            $data = array(
                'device' => 'web',
                'station_id' => $station_id,
                'quantity' => htmlentities($this->input->post('quantity')),
                'type' => htmlentities($this->input->post('type')),
                'date_stock' => date("Y-m-d H:i:s"),
                'name'=> htmlentities($this->input->post('name')),
                'departement_id'=> htmlentities($this->input->post('departement_id')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'type'=> htmlentities($this->input->post('type')),
                'prix'=> htmlentities($this->input->post('prix')),
                'country_id' => $this->session->userdata('country_id'),
                'company_id' => $company_id
            );

            // historic des ravitaillement
            $data_log = array(
                'station_id' => $station_id,
                'company_id' => $company_id,
                'city_id' => $city_id,
                'cat_id' => $cat_id,
                'commune_id' => $cat_id,
                'sub_cat_id' => $sub_cat_id,
                'twon_id' => $twon_id,
                'quantity' => htmlentities($this->input->post('quantity')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'cd_fluid_id' => $data['id'],
                'type' => htmlentities($this->input->post('type')),
                'date_stock' => date("Y-m-d H:i:s"),
                'user_id' => htmlentities($this->input->post('user_id')),
                'country_id' => $this->session->userdata('country_id'),
                'company_deliver' => htmlentities($this->input->post('company_deliver')),
                'camion_number' => htmlentities($this->input->post('camion_number')),
                'driver_name' => htmlentities($this->input->post('driver_name')),
                'driver_phone' => htmlentities($this->input->post('driver_phone')),
                'driver_number' => htmlentities($this->input->post('driver_phone')),
                'code'=> htmlentities($this->input->post('code')),
                'name'=> htmlentities($this->input->post('name')),
                'stock_actuel' => $stock_actuel

            );

            // Ajout a la quantite existent
            if ($this->item->ravitaillement($data)) {

                if (!$this->item->ravitaillement_log($data_log)) {
                    $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                }
                $this->session->set_flashdata('success', 'Le ravitaillement a été enregistré avec succès.  ');
            } else {
                $this->session->set_flashdata('error', 'A Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('felicitation/').url_encode($station_id));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_info($station_id); // One station
        $data['station_id'] = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence();
        $data['gasoil'] = $this->item->get_info_gasoil();
        $data['kerosene'] = $this->item->get_info_kerosene();
        $data['huile'] = $this->item->get_info_huile();

        $this->load->view('layout/themes/header',array());
        $this->load->view('layout/themes/nav',array());
        $this->load->view('desk/desk', $data);
        $this->load->view('layout/themes/footer',array());
    }


    /***
     * Add Stock Fuel
     * @param int $station_id
     */
    function add_stock_fuel($station_id=0)
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $query    = $this->db->get_where('cd_items', array('id' => $station_id, 'is_published' => 1));  // Station fetch
            if ($query->num_rows() > 0) {
                $row           = $query->row();
                $city_id       = $row->city_id;
                $cat_id        = $row->cat_id;
                $sub_cat_id    = $row->sub_cat_id;
                $twon_id       = $row->twon_id;
                $company_id       = $row->company_id;
            }

            $initial_stock = $this->db->get_where('cd_fluid', array('type' => htmlentities($this->input->post('type')),'company_id' => htmlentities($this->input->post('company_id')),'station_id'=>$station_id))->row()->quantity;
            $stock_actuel = $initial_stock + htmlentities($this->input->post('quantity'));

            $data = array(
                'device' => 'web',
                'station_id' => $station_id,
                'quantity' => htmlentities($this->input->post('quantity')),
                'type' => htmlentities($this->input->post('type')),
                'date_stock' => date("Y-m-d H:i:s"),
                'name'=> htmlentities($this->input->post('name')),
                'departement_id'=> htmlentities($this->input->post('departement_id')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'type'=> htmlentities($this->input->post('type')),
                'mark' => htmlentities($this->input->post('mark')),
                'country_id' => $this->session->userdata('country_id'),
                'company_id' => $company_id
            );

            // Ajout a la quantite existent
            if ($this->item->ravitaillement($data)) {
                // historic des ravitaillement
                $data_log = array(
                    'station_id' => $station_id,
                    'company_id' => $company_id,
                    'city_id' => $city_id,
                    'cat_id' => $cat_id,
                    'commune_id' => $cat_id,
                    'sub_cat_id' => $sub_cat_id,
                    'twon_id' => $twon_id,
                    'quantity' => htmlentities($this->input->post('quantity')),
                    'user_id'=> htmlentities($this->input->post('user_id')),
                    'cd_fluid_id' => $data['id'],
                    'type' => htmlentities($this->input->post('type')),
                    'date_stock' => date("Y-m-d H:i:s"),
                    'user_id' => htmlentities($this->input->post('user_id')),
                    'mark' => htmlentities($this->input->post('mark')),
                    'country_id' => $this->session->userdata('country_id'),
                    'company_deliver' => htmlentities($this->input->post('company_deliver')),
                    'camion_number' => htmlentities($this->input->post('camion_number')),
                    'driver_name' => htmlentities($this->input->post('driver_name')),
                    'driver_phone' => htmlentities($this->input->post('driver_phone')),
                    'driver_number' => htmlentities($this->input->post('driver_phone')),
                    'code'=> htmlentities($this->input->post('code')),
                    'name'=> htmlentities($this->input->post('name')),
                    'stock_initial' => $initial_stock,
                    'stock_actuel' => $stock_actuel
                );

                if (!$this->item->ravitaillement_log($data_log)) {
                    $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                }
                $this->session->set_flashdata('success', 'Le ravitaillement a été enregistré avec succès.');
            } else {
                $this->session->set_flashdata('error', 'A Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('felicitation/').url_encode($station_id));
        }


        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_info($station_id); // One station
        $data['station_id'] = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence();
        $data['gasoil'] = $this->item->get_info_gasoil();
        $data['kerosene'] = $this->item->get_info_kerosene();
        $data['huile'] = $this->item->get_info_huile();

        $this->load->view('layout/themes/header',array());
        $this->load->view('layout/themes/nav',array());
        $this->load->view('desk/desk', $data);
        $this->load->view('layout/themes/footer',array());
    }



    function validate__data_bad() {

        if ($this->input->server('REQUEST_METHOD')=='POST') {
            $data = array(
                'type' => htmlentities($this->input->post('type')),
                'camion_number' => htmlentities($this->input->post('camion_number')),
                //'date_stock' => date("Y-m-d H:i:s"),
                'driver_name' => htmlentities($this->input->post('driver_name')),
                'driver_phone' => htmlentities($this->input->post('driver_phone'))
            );

        }else{

        }

    }










    function ajax_edit($id)
    {
        $data = $this->db->get_where('cd_jauge',array('id'=>$id))->result();
        echo json_encode($data);
    }


    function jauge_to_update()
    {

        if ($this->input->server('REQUEST_METHOD')=='POST') {
            $data = array(
                'jauge_to' => htmlentities($this->input->post('jauge_to')),
            );
            $id = array('id' => $this->input->post('id'));

            if ($this->item->jauge_to_update($data,$id))  {}
            echo json_encode(array("status" => TRUE));
            redirect(site_url('soaco_e-Station/'));



        }

    }


    function jauge_to_update_2(){
        $id=$this->input->post('id');
        $jauge_to=$this->input->post('jauge_to');

        $this->db->set('jauge_to', $jauge_to);
        $this->db->where('id', $id);
        $result=$this->db->update('cd_jauge');
        if (!$result) {
            echo json_encode(array("status" => TRUE));
        }
        return $result;
    }



    function profile()
    {
        $user_id = $this->user->get_logged_in_user_info()->user_id;
        $status = "";
        $message = "";

        if ($this->input->server('REQUEST_METHOD')=='POST') {
            $user_data = array(
                'user_name' => htmlentities($this->input->post('user_name'))
            );

            //If new user password exists,change password
            if ($this->input->post('user_password')!='') {
                $user_data['user_pass'] = md5($this->input->post('user_password'));
            }

            if ($this->user->update_profile($user_data,$user_id)) {
                $status = 'success';
                $message = 'User is successfully updated.';
            } else {
                $status = 'error';
                $message = 'Database error occured.Please contact your system administrator.';
            }
        }

        $data['user'] = $this->user->get_info($user_id);
        $data['status'] = $status;
        $data['message'] = $message;

        $content['content'] = $this->load->view('users/profile',$data,true);




        $this->load_template($content);
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

    function backup()
    {
        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup =& $this->dbutil->backup();

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('soaco.zip', $backup);
    }


    /**
     *  Ravitaillement
     * @param $data_id
     */
    function add($station_id=0)
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $query    = $this->db->get_where('cd_items', array('id' => $station_id, 'is_published' => 1));  // Station fetch
            if ($query->num_rows() > 0) {
                $row           = $query->row();
                $city_id       = $row->city_id;
                $cat_id        = $row->cat_id;
                $sub_cat_id    = $row->sub_cat_id;
                $twon_id       = $row->twon_id;
                $company_id       = $row->company_id;
            }

            $data = array(
                'device' => 'web',
                'station_id' => $station_id,
                'quantity' => htmlentities($this->input->post('quantity')),
                'type' => htmlentities($this->input->post('type')),
                'date_stock' => date("Y-m-d H:i:s"),
                'name'=> htmlentities($this->input->post('name')),
                'departement_id'=> htmlentities($this->input->post('departement_id')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'type'=> htmlentities($this->input->post('type')),
                'prix'=> htmlentities($this->input->post('prix')),
                'country_id' => $this->session->userdata('country_id'),
                'company_id' => $company_id
            );


            if ($this->item->ravitaillement($data)) {
                // cd_ravital_log

                $data_log = array(
                    'station_id' => $station_id,
                    'city_id' => $city_id,
                    'cat_id' => $cat_id,
                    'commune_id' => $cat_id,
                    'sub_cat_id' => $sub_cat_id,
                    'twon_id' => $twon_id,
                    'quantity' => htmlentities($this->input->post('quantity')),
                    'user_id'=> htmlentities($this->input->post('user_id')),
                    'cd_fluid_id' => $data['id'],
                    'type' => htmlentities($this->input->post('type')),
                    'date_stock' => date("Y-m-d H:i:s"),
                    'user_id' => htmlentities($this->input->post('user_id')),
                    'country_id' => $this->session->userdata('country_id'),
                    'company_id' => $company_id
                );


                if (!$this->item->ravitaillement_log($data_log)) {
                    $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                }
                $this->session->set_flashdata('success', 'Le ravitaillement a été enregistré avec succès');
            } else {
                $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('fixer/').url_encode($station_id));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_info($station_id); // One station
        $data['station_id'] = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence();
        $data['gasoil'] = $this->item->get_info_gasoil();
        $data['kerosene'] = $this->item->get_info_kerosene();
        $data['huile'] = $this->item->get_info_huile();

        $this->load->view('layout/themes/header',array());
        $this->load->view('layout/themes/nav',array());
        $this->load->view('desk/desk', $data);
        $this->load->view('layout/themes/footer',array());
    }






    function ok($data_id = 0)
    {
        $station_id = url_decode($data_id);
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('desk'));
        }
        //  $content['contenu'] = $this->load->view('desk/desk', array(), true);
        // $this->station_template($content);
//        $this->load->view('desk/desk');
        // $data['user'] = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->result();

        // $stations_id = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_info($station_id); // One station

        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence();
        $data['gasoil'] = $this->item->get_info_gasoil();
        $data['kerosene'] = $this->item->get_info_kerosene();
        $data['huile'] = $this->item->get_info_huile();

        //  $data['page_title'] = 'Gestion de Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/desk',$data);
        $this->load->view('layout/themes/footer',$data);

    }







}
?>