<?php
require_once('Main.php');

class Desk extends Main
{
    function __construct()
    {
        parent::__construct( NO_ACCESS_CONTROL );
        $this->load->library('common');
        $this->load->helper('number');
    }

    function index($data_id = 0)
    {
        $user_id = url_decode($data_id);

        if ($this->session->userdata('role_id') == 2)
            redirect(site_url( "exit"));
        if ($this->session->userdata('role_id') == 3)
            redirect(site_url( "exit"));
        if ($this->session->userdata('role_id') == 4)
            redirect(site_url( "exit"));
        if ($this->session->userdata('role_id') == 7)
            redirect(site_url( "exit"));

        //$station_id = url_decode($data_id);
        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;  // Station ID
        $data['stations'] = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id));  // Station ID
        //$data['station_id'] = $station_id;
        $chart = $this->item->get_data()->result();
        $data['data'] = json_encode($chart);

        $chart_ess = $this->item->get_chart_essence()->result();
        $data['ess_chart'] = json_encode($chart_ess);

        $chart_gas = $this->item->get_chart_gasoil()->result();
        $data['gas_chart'] = json_encode($chart_gas);

        $chart_pet = $this->item->get_chart_petrole()->result();
        $data['pet_chart'] = json_encode($chart_pet);

        $chart_date = $this->item->get_chart_date()->result();
        $data['date_chart'] = json_encode($chart_date);

        // raavitaillement Logs
        $pages = $this->config->item('pagination');
        $pages['base_url'] = site_url('items/index');
        $pages['total_rows'] = $this->item->count_all_ravit_log($station_id,1);
        $data['ravit_logs'] = $this->item->get_all_ravit_log($station_id, 7, $this->uri->segment(3));
        $data['pag'] = $pages;

        // table Historic de vente
        $this->session->unset_userdata('searchterm');
        $pags = $this->config->item('pagination');
        $pags['base_url']   = site_url('desk/index/');
        $pags['total_rows'] = $this->item->count_all_fluid_log();
        $data['selling']   = $this->item->get_all_fluid_log($station_id,$pags['per_page'],$this->uri->segment(3)); // $pag['per_page']
        $data['pags']       = $pags;
        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

        // OIL
        $pag_oil['base_url']   = site_url('desk/index/');
        $pag_oil['total_rows'] = $this->item->count_all_fluid_log_oil();
        $data['sell_oil']   = $this->item->get_all_fluid_log_oil($station_id,$pag_oil['per_page'],$this->uri->segment(3)); // $pag['per_page']
        $data['pag_oil']       = $pag_oil;

        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));

        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('desk'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;
        $data['societe'] = $this->user->get_one_company_info($company_id); // One company
        $data['station'] = $this->item->get_station_info($station_id); // One station


        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
       // $data['petrole'] = $this->item->get_infos_petrole();
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();
        $data['secure_code']   = $this->item->get_secure_code($station_id,7,$this->uri->segment(3));

        $data['gaz'] = $this->item->get_info_gaz(6,$station_id);
        $data['lubrifiant'] = $this->item->get_info_lubrifiants(7,$station_id);
        $data['gaz65'] = $this->item->get_info_stock($station_id,65);
        $data['gaz66'] = $this->item->get_info_stock($station_id,66);
        $data['gaz612'] = $this->item->get_info_stock($station_id,612);
        $data['gaz652'] = $this->item->get_info_stock($station_id,652);

        $data['page_title'] = 'Gestion de Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/desk',$data);
        $this->load->view('layout/themes/footer',$data);

    }


    function index_chart(){
        $chart = $this->desk->get_data()->result();
        $data['chart'] = json_encode($chart);
        $this->load->view('chart_view',$data);
    }



    function get_station_modif($cat_id)
    {
        $query = $this->db->get_where('cd_items' , array('sub_cat_id'=>$cat_id,'is_published' =>1));
        echo json_encode($query->result());
    }


    function get_chart_data() {

        if (isset($_POST['start']) AND isset($_POST['end'])) {
            $start_date = $_POST['start'];
            $end_date = $_POST['end'];
            $results = $this->item->get_chart_data($start_date, $end_date);
            if ($results === NULL) {
                $data['datas'] = json_encode('No record found');
            } else {
                $data['datas'] = json_encode($results);
            }
        } else {
            $data['datas'] = json_encode('Date must be selected.');

        }

        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/desk',$data);
        $this->load->view('layout/themes/footer',$data);
    }
// 03/12/2012 - 03/18/2012



    public function get_chart_datas() {
        if (isset($_POST['start']) AND isset($_POST['end'])) {
            $start_date = $_POST['start'];
            $end_date = $_POST['end'];
            $results = $this->item->get_chart_data($start_date, $end_date);
            if ($results === NULL) {
                echo json_encode('No record found');
            } else {
                $json = '[';
                $counter = 1;
                foreach ($results as $result) {
                    $json .= '[';
                    $json .= strtotime($result->temp_date);
                    $json .= ',';
                    $json .= $result->temp_min;
                    $json .= ',';
                    $json .= $result->temp_max;
                    $json .= ']';
                    if ($counter < count($results)) {
                        $json .= ',';
                    }
                    $counter++;
                }
                $json .= ']';
                echo $json;
            }
        } else {
            echo json_encode('Date must be selected.');
        }
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
                $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
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


    /***
     * Achat d`un produit
     * @param $data_id
     */
    function add($data_id)
    {
        $station_id = url_decode($data_id);

       $initial_stock = $this->db->get_where('cd_fluid', array('type' => htmlentities($this->input->post('type')),'company_id' => htmlentities($this->input->post('company_id')),'station_id'=>$station_id))->row()->quantity;
       $stock_restant = $initial_stock - htmlentities($this->input->post('quantity_in'));

        //Got type paiment
        $data = $this->code->get_paiement_by(htmlentities($this->input->post('pay_id')));

       // Cash Money of oil
        $price_by = $this->db->get_where('cd_price', array('type' => htmlentities($this->input->post('type')),'country_id' => $this->session->userdata('country_id')))->row()->prix;
        $cash = ($price_by) * (htmlentities($this->input->post('quantity_in')));

        //  validation card
        if ( ! $this->check_card((htmlentities($this->input->post('code'))),$data->check_id,$cash)) {
            redirect(site_url('soaco_e-Station/').$data_id);
        }

        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $data = array(
                'quantity_in' => htmlentities($this->input->post('quantity_out')),
                'cd_fluid_id' => htmlentities($this->input->post('cd_fluid_id')),
                'company_id' => htmlentities($this->input->post('company_id')),
              //  'company_id' => $this->session->userdata('company_id'),

                'city_id' => htmlentities($this->input->post('city_id')),
                'device' => 'web',
                'station_id' => $station_id,
               // 'stock_restant' => $stock_restant,
                'quantity_in' => htmlentities($this->input->post('quantity_in')),
                'type' => htmlentities($this->input->post('type')),
                'date_stock' =>  time(),
                'name'=> htmlentities($this->input->post('name')),
                'departement_id'=> htmlentities($this->input->post('departement_id')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'type'=> htmlentities($this->input->post('type')),
                'lastime_sel' => date("Y-m-d H:i:s"),
                'time_out' => date("Y-m-d H:i:s"),
                'new_bottle' => htmlentities($this->input->post('new_bottle')),
                'country_id' => $this->session->userdata('country_id')
            );




            // check fluid
            if (!$this->check_fluid($data['quantity_in'],$station_id,$data['type'])) {
                $buy_fail = array(
                    'station_id' => $station_id,
                    'city_id' => htmlentities($this->input->post('city_id')),
                    'departement_id'=> htmlentities($this->input->post('departement_id')),
                    'company_id' => htmlentities($this->input->post('company_id')),
                    'quantity_out' => htmlentities($this->input->post('quantity_in')),
                    'user_id'=> htmlentities($this->input->post('user_id')),
                    'cd_fluid_id' => $data['id'],
                    'commune_id'=> htmlentities($this->input->post('commune_id')),
                    'name'=> htmlentities($this->input->post('name')),
                    'type' => htmlentities($this->input->post('type')),
                    'time_out' => date("Y-m-d H:i:s"),
                    'status' => 0,  // buy faild
                    'new_bottle' => htmlentities($this->input->post('new_bottle')),
                   // 'initial_stock' => htmlentities($this->input->post('initial_stock')),
                    'initial_stock' => $initial_stock,
                    'stock_restant' => $stock_restant,
                    'country_id' => $this->session->userdata('country_id')

                );
                $this->item->fluid_log($buy_fail);

                redirect(site_url('soaco_e-Station/').$data_id);
            }

            if ($this->item->pay_fluid($data)) {

                $fluid_log = array(
                    'station_id' => $station_id,
                    'city_id' => htmlentities($this->input->post('city_id')),
                    'departement_id'=> htmlentities($this->input->post('departement_id')),
                    'company_id' => htmlentities($this->input->post('company_id')),
                    'quantity_out' => htmlentities($this->input->post('quantity_in')),
                    'user_id'=> htmlentities($this->input->post('user_id')),
                    'prix'=> htmlentities($this->input->post('prix'))?:0,
                    'cd_fluid_id' => $data['id'],
                    'commune_id'=> htmlentities($this->input->post('commune_id')),
                    'name'=> htmlentities($this->input->post('name')),
                    'type' => htmlentities($this->input->post('type')),
                    'time_out' => date("Y-m-d H:i:s"),
                    'status' => 1,  // buy success
                    'new_bottle' => 0,  // pas de consignation
                    'is_consign'=>1,
                    'stock_restant' => $stock_restant,
                    'initial_stock' => $initial_stock,
                    'new_bottle' => htmlentities($this->input->post('new_bottle')),
                  //  'initial_stock' => htmlentities($this->input->post('initial_stock')),
                    'country_id' => $this->session->userdata('country_id')

                );
                if (!$this->item->fluid_log($fluid_log)) {
                    $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                }

                $this->session->set_flashdata('success', 'Operation réussie');
            } else {
                $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('soaco_e-Station/').$data_id);
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








    function add_fuel($data_id)
    {
        $station_id = url_decode($data_id);

        $initial_stock = $this->db->get_where('cd_fluid', array('type' => htmlentities($this->input->post('type')),'company_id' => htmlentities($this->input->post('company_id')),'station_id'=>$station_id))->row()->quantity;
        $stock_restant = $initial_stock - htmlentities($this->input->post('quantity_in')) ;

        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $data = array(
                'quantity_in' => htmlentities($this->input->post('quantity_out')),
                'cd_fluid_id' => htmlentities($this->input->post('cd_fluid_id')),
                'city_id' => htmlentities($this->input->post('city_id')),
                'device' => 'web',
                'station_id' => $station_id,
                'quantity_in' => htmlentities($this->input->post('quantity_in')),
                'type' => htmlentities($this->input->post('type')),
                'date_stock' =>  time(),
                'name'=> htmlentities($this->input->post('name')),
                'departement_id'=> htmlentities($this->input->post('departement_id')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'type'=> htmlentities($this->input->post('type')),
                'mark' => htmlentities($this->input->post('mark')),
                'lastime_sel' => date("d-m-Y H:i:s"),
                'time_out' => date("d-m-Y H:i:s"),
                'prix'=> htmlentities($this->input->post('prix')),
                'new_bottle' => htmlentities($this->input->post('new_bottle')),
                'company_id' => htmlentities($this->input->post('company_id')),
                'country_id' => $this->session->userdata('country_id')
            );
           // var_dump($data);
           // exit();
            // check fluid
            if (!$this->check_fluid($data['quantity_in'],$station_id,$data['type'])) {
                $buy_fail = array(
                    'station_id' => $station_id,
                    'city_id' => htmlentities($this->input->post('city_id')),
                    'departement_id'=> htmlentities($this->input->post('departement_id')),
                    'company_id' => htmlentities($this->input->post('company_id')),
                    'quantity_out' => htmlentities($this->input->post('quantity_in')),
                    'user_id'=> htmlentities($this->input->post('user_id')),
                    'cd_fluid_id' => $data['id'],
                    'commune_id'=> htmlentities($this->input->post('commune_id')),
                    'name'=> htmlentities($this->input->post('name')),
                    'type' => htmlentities($this->input->post('type')),
                    'mark' => htmlentities($this->input->post('mark')),
                    'time_out' => date("d-m-Y H:i:s"),
                    'status' => 0,  // buy faild
                    'new_bottle' => 0,  // pas de consignation
                    'is_consign'=>0,
                    'is_oil' => 1,     // is oil
                    'country_id' => $this->session->userdata('country_id')
                );
                $this->item->fluid_log($buy_fail);

                redirect(site_url('soaco_e-Station/').$data_id);
            }

            if ($this->item->pay_fluid($data)) {

                // historic de vente
                $fluid_log = array(
                    'station_id' => $station_id,
                    'city_id' => htmlentities($this->input->post('city_id')),
                    'departement_id'=> htmlentities($this->input->post('departement_id')),
                    'company_id' => htmlentities($this->input->post('company_id')),
                    'quantity_out' => htmlentities($this->input->post('quantity_in')),
                    'user_id'=> htmlentities($this->input->post('user_id')),
                    'prix'=> htmlentities($this->input->post('prix')),
                    'cd_fluid_id' => $data['id'],
                    'commune_id'=> htmlentities($this->input->post('commune_id')),
                    'name'=> htmlentities($this->input->post('name')),
                    'type' => htmlentities($this->input->post('type')),
                    'mark' => htmlentities($this->input->post('mark')),
                    'time_out' => date("d-m-Y H:i:s"),
                    'status' => 1,  // buy success
                    'new_bottle' => 0,  // pas de consignation
                    'is_consign'=>0,
                    'is_oil' => 1,      // is oil
                    'country_id' => $this->session->userdata('country_id'),
                    'initial_stock' => $initial_stock,
                    'stock_restant' => $stock_restant
                );
                if (!$this->item->fluid_log($fluid_log)) {
                    $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                }
                $this->session->set_flashdata('success', 'Operation réussie');
            } else {
                $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('soaco_e-Station/').$data_id);
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









    function sent_notes($data_id)
    {
        $station_id = url_decode($data_id);
        if ($this->input->server('REQUEST_METHOD')=='POST') {
            $data_msg = array(
                'titre_msg' => htmlentities($this->input->post('titre_msg')),
                'message' => htmlentities($this->input->post('message')),
                'type_msg' => htmlentities($this->input->post('type_msg')),
                'station_id' => htmlentities($this->input->post('station_id')),
                'name'=> htmlentities($this->input->post('name')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'city_id'=> htmlentities($this->input->post('city_id')),
                'email'=> htmlentities($this->input->post('email')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'is_sending_by_station'=> htmlentities($this->input->post('is_sending_by_station')),
                'company_id'=> htmlentities($this->input->post('company_id')),
                'country_id'=> htmlentities($this->input->post('country_id')),
                'is_sending_by_station' =>1,  // Sent from Station
                'add_time' => date("d-m-Y H:i:s"),
                'is_read'=>0  // unread
            );
        }
        if ($this->item->sent_notes($data_msg)) {
            $this->session->set_flashdata('success', 'Message envoyer avec succes');
        } else {
            $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
        }

        redirect(site_url('messages/'));
        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_info($station_id); // One station
        $data['station_id'] = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        $data['essence'] = $this->item->get_info_essence();
        $data['gasoil'] = $this->item->get_info_gasoil();
        $data['kerosene'] = $this->item->get_info_kerosene();
        $data['huile'] = $this->item->get_info_huile();
        $this->load->view('layout/themes/header',array());
        $this->load->view('layout/themes/nav',array());
        $this->load->view('desk/desk', $data);
        $this->load->view('layout/themes/footer',array());

    }







    function add_invoice()
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $data = array(
                'client_name' => htmlentities($this->input->post('client_name')),
                'client_phone' => htmlentities($this->input->post('client_phone')),
                'invoice_number' => htmlentities($this->input->post('invoice_number')),
                'add_time' => date("d-m-Y H:i:s"),
                'client_car'=> htmlentities($this->input->post('client_car')),
                'station_id'=> htmlentities($this->input->post('station_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'country_id' => $this->session->userdata('country_id')

            );
            // creat invoice
            if ($this->item->add_facture_creator($data)) {
                $this->session->set_flashdata('success', 'Facture a été creeé avec succès. Cliquez en dessous pour imprimer ');
            } else {
                $this->session->set_flashdata('error', 'A Une erreur de système du à l’internet s\'est produite. Veuillez réessayer encore');
                redirect(site_url('soaco_e-Station'));
            }
            redirect(site_url('soaco_e-facture/').url_encode($data['id']));
        }

        $this->load->view('layout/themes/header',array(),true);
        $this->load->view('layout/themes/nav',array(),true);
        $this->load->view('desk/desk',array(),true);
        $this->load->view('layout/themes/footer',array(),true);
    }





    function check_fluid($buy = 0,$station_id = 0,$type = 0){
        //quantite de fluid dans le tank
        $fluid =$this->db->get_where('cd_fluid',array('station_id'=>$station_id,'type'=>$type))->row()->quantity;

        if ($fluid < $buy){
            $this->session->set_flashdata('error', 'Stock insuffisant');
            return false;
        }
        return true;

    }


/***

    function check_existing_qty($items_id, $qty)
    {
        $items_info = $this->db->where('items_id', $items_id)->get('tbl_items')->row();
        if ($items_info->quantity != $qty) {
            if ($qty > $items_info->quantity) {
                $reduce_qty = $qty - $items_info->quantity;
                if (!empty($items_info->saved_items_id)) {
                    $this->invoice_model->reduce_items($items_info->saved_items_id, $reduce_qty);
                }
            }
            if ($qty < $items_info->quantity) {
                $return_qty = $items_info->quantity - $qty;
                if (!empty($items_info->saved_items_id)) {
                    $this->invoice_model->return_items($items_info->saved_items_id, $return_qty);
                }
            }
        }
        return true;

    }

****/






    /**
     * Check code
     */
    function check_card($code,$check_id,$cash)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Got amond
            $query    = $this->db->get_where('cd_cards', array('card_serial' => $code, 'is_published' => 1));  // Station fetch
            if ($query->num_rows() > 0) {
                $row           = $query->row();
                $initial_moeny       = $row->initial_moeny;
                $rest_moeny        = $row->rest_moeny;
            }

            // Montant restant dans la carte
            $moneyCardNow = $initial_moeny-$rest_moeny;

            $data = $this->code->check_coupon($code);

            if ($check_id == 1){  // ony code
                if ($data->card_serial == "") {
                    $this->session->set_flashdata('error','  Numero incorrect ou inexistant');
                    return false;
                }elseif ($data->is_published == 0){
                    $this->session->set_flashdata('error','  Votre carte numéro  '.$code.'  est invalide');
                    return false;
                }elseif ($cash > $moneyCardNow){
                    $this->session->set_flashdata('error','  Montant insuffisant.'.'  Solde de la carte est de  '.$moneyCardNow);
                    return false;
                }
            }elseif ($check_id == 2){  // only phone number
                if ($code==0 || $code == null) {
                    $this->session->set_flashdata('error','  Saisissez numero de telephone du client');
                    return false;
                }
            }
            else{
                return true;

                // code rest_money
            }
            $this->item->pay_money_card($code,$cash,$moneyCardNow);
            return true;
        }

    }







}
?>