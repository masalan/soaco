<?php
require_once('Main.php');

class Invoice extends Main
{
    function __construct()
    {
        parent::__construct( NO_ACCESS_CONTROL );
        $this->load->library('common');
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('string');


    }

    function index($data_id = 0)
    {

        $id = url_decode($data_id);

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('desk'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        $this->load->helper('number');

        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $data['societe'] = $this->user->get_one_company_info($company_id); // One company

        $data['invoice'] = $this->item->get_invoice($id,$station_id);
       // var_dump($data['invoice']);
       // exit();




        $data['page_title'] = 'Ma facture';
        $this->load->view('layout/themes/header',$data);
         $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/invoice',$data);
        $this->load->view('layout/themes/footer',$data);
    }



    /***
     *  Creation code barre
     * @param $ebia_id
     * @return mixed
     */
    public function barcode($ebia_id)
    {
        return $this->item->create_barcode($ebia_id);
    }


    /***
     * Creat Invoice
     * @param int $station_id
     */
    function add_invoice()
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {



            $query    = $this->db->get_where('cd_items', array('id' => htmlentities($this->input->post('station_id')), 'is_published' => 1));  // Station fetch
            if ($query->num_rows() > 0) {
                $row           = $query->row();
                $city_id       = $row->city_id;
                $cat_id        = $row->cat_id;
                $sub_cat_id    = $row->sub_cat_id;
                $twon_id       = $row->twon_id;
            }

            $data = array(
                'client_name' => htmlentities($this->input->post('client_name')),
                'client_phone' => htmlentities($this->input->post('client_phone')),
                'invoice_number' => htmlentities($this->input->post('invoice_number')),
                'add_time' => date("d-m-Y H:i:s"),
                'country_id' => $this->session->userdata('country_id'),

                'city_id' => $city_id,
                'cat_id' => $cat_id,
                'sub_cat_id' => $sub_cat_id,
                'twon_id' => $twon_id,



                'client_car'=> htmlentities($this->input->post('client_car')),
                'station_id'=> htmlentities($this->input->post('station_id')),
                'company_id'=> htmlentities($this->input->post('company_id')),
                'user_id'=> htmlentities($this->input->post('user_id'))
            );

            //var_dump($data);
           // exit();


            //if ($this->db->insert('cd_invoice',$data)) {
           if ($this->item->add_facture_creator($data)) {
                    $this->session->set_flashdata('success', 'Facture a été creeé avec succès. Cliquez en dessous pour imprimer ');
            } else {

                $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
                redirect(site_url('soaco_e-Station'));
            }
            redirect(site_url('soaco_e-facture/').url_encode($data['id']));
        }

        $this->load->view('layout/themes/header',array(),true);
        $this->load->view('layout/themes/nav',array(),true);
        $this->load->view('desk/desk',array(),true);
        $this->load->view('layout/themes/footer',array(),true);
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
            $data = array(
                'device' => 'web',
                'station_id' => $station_id,
                'quantity' => htmlentities($this->input->post('quantity')),
                'type' => htmlentities($this->input->post('type')),
                'date_stock' => strtotime(date("Y-m-d H:i:s")),
                'name'=> htmlentities($this->input->post('name')),
                'departement_id'=> htmlentities($this->input->post('departement_id')),
                'commune_id'=> htmlentities($this->input->post('commune_id')),
                'user_id'=> htmlentities($this->input->post('user_id')),
                'type'=> htmlentities($this->input->post('type')),
                'prix'=> htmlentities($this->input->post('prix')),
            );


            $query    = $this->db->get_where('cd_items', array('id' => $station_id, 'is_published' => 1));  // Station fetch
            if ($query->num_rows() > 0) {
                $row           = $query->row();
                $city_id       = $row->city_id;
                $cat_id        = $row->cat_id;
                $sub_cat_id    = $row->sub_cat_id;
                $twon_id       = $row->twon_id;
            }

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
                    'date_stock' => strtotime(date("Y-m-d H:i:s")),
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