<?php
require_once('Main.php');

class Reglage extends Main
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
            redirect(site_url('desk'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $pag['base_url'] = site_url('reglage/index');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('reglage/index');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;

        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $data['societe'] = $this->user->get_one_company_info($company_id); // One company


        // Maqrque d`huile
        $this->session->unset_userdata('searchterm');
        $pag_mark = $this->config->item('pagination');
        $pag_mark['base_url']   = site_url('reglage/index/');
        $pag_mark['total_rows'] = $this->item->count_all_mark_oils($station_id);
        $data['marks']   = $this->item->get_all_mark_oil($station_id,$pag_mark['per_page'],$this->uri->segment(3)); // $pag['per_page']
        $data['pag_mark']       = $pag_mark;


        // Format d`huile
        $this->session->unset_userdata('searchterm');
        $pag_format = $this->config->item('pagination');
        $pag_format['base_url']   = site_url('reglage/index/');
        $pag_format['total_rows'] = $this->item->count_all_mark_format($station_id,$company_id);
        $data['format']   = $this->item->get_all_oil_format($station_id,$company_id,$pag_format['per_page'],$this->uri->segment(3)); // $pag['per_page']
        $data['pag_format']       = $pag_format;
        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;



        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        // $data['petrole'] = $this->item->get_infos_petrole();
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();

        $data['item'] = $this->item->get_info($station_id);

        // services station
        $data['serrvice_station']   = $this->item->get_all_service_live_station($station_id,$company_id);

       // var_dump( $data['serrvice_station']);
       // exit();

        $data['page_title'] = 'Services de la Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/reglage',$data);
        $this->load->view('layout/themes/footer',$data);
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
                'country_id' => $this->session->userdata('country_id')

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
                    'date_stock' => date("Y-m-d H:i:s"),
                    'user_id' => htmlentities($this->input->post('user_id')),
                    'country_id' => $this->session->userdata('country_id')


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




    function add_mark($station_id=0)
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {


            $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;

           // var_dump($station_id,$company_id);
           // exit();

            $data = array(
                'is_active' => '1',
                'station_id' => $station_id,
                'company_id' => $company_id,
                'name' => htmlentities($this->input->post('name')),
                'added' => date("Y-m-d H:i:s"),
            );

            if ($this->item->add_mark($data)) {

                $this->session->set_flashdata('success', 'La marque d`huile a été enregistré avec succès');
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


    function add_format($station_id=0)
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;

            $data = array(
                'is_active' => '1',
                'station_id' => $station_id,
                'name' => htmlentities($this->input->post('name')),
                'added' => date("Y-m-d H:i:s"),
                'mark_id' => htmlentities($this->input->post('mark_id')),
                'type_id' => htmlentities($this->input->post('type_id')),
                'country_id' => $this->session->userdata('country_id'),
                'company_id' => $company_id
            );

            if ($this->item->add_mark_format($data)) {
                $this->session->set_flashdata('success', 'La marque d`huile a été enregistré avec succès');
            } else {
                $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('fixer/').url_encode($station_id));
        }

        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_info($station_id); // One station
        $data['station_id'] = $this->db->get_where('be_users' , array('user_id' =>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        $this->load->helper('number');

        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        // $data['petrole'] = $this->item->get_infos_petrole();
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();


        $this->load->view('layout/themes/header',array());
        $this->load->view('layout/themes/nav',array());
        $this->load->view('desk/desk', $data);
        $this->load->view('layout/themes/footer',array());
    }


    /**
     * Get format fuel mark
     * @param $id
     */
    function get_format_fuel($id)
    {
        $query = $this->db->get_where('cd_format_fuel', array('mark_id'=>$id,'is_active' =>1))->result_array();
        foreach ($query as $row) {
            echo '<option value="' . $row['type_id'].'">Format de '.$row['name'].' litre(s)</option>';
        }
    }


    /**
     * Delete format oil
     * @param int $id
     */
    function delete($id=0)
    {
        if($this->item->delete_format_oil($id)) {
            $this->session->set_flashdata('success','Le fortmat d`huile a été supprime');
            // add log
        } else {
            $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
        }
        redirect(site_url('fixer/'));
    }


    /**
     * Publish format oil
     * @param int $id
     */
    function format_publish($id=0)
    {
        if($this->item->publish_format_oil($id)) {
            $this->session->set_flashdata('success','Le fortmat d`huile a été activé');
            // add log
        } else {
            $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
        }
        redirect(site_url('fixer/'));
    }


    /**
     * Unpublish Format Oil
     * @param int $id
     */
    function format_unpublish($id=0)
    {
        if($this->item->unpublish_format_oil($id)) {
            $this->session->set_flashdata('success','Le fortmat d`huile a été desactivé');
            // add log
        } else {
            $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
        }
        redirect(site_url('fixer/'));
    }


    /**
     * update Alert Fuel
     * @param int $id
     */
    function alert_fuel($id=0)
    {
        if ($this->input->server('REQUEST_METHOD')=='POST') {
            $data = array(
                'alert_limit' => htmlentities($this->input->post('alert_limit')),
                'station_id' => htmlentities($this->input->post('station_id')),
                'update_time' => date("Y-m-d H:i:s")
            );
            if ($this->item->update_alert_fuel($id,$data)) {
                $this->session->set_flashdata('success', 'La marque d`huile a été enregistré avec succès');
            } else {
                $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
            }
            redirect(site_url('fixer/').url_encode(htmlentities($this->input->post('station_id'))));

        }
    }

    function arret_service($id=0)
    {
        if($this->item->arret_service($id)) {
            $this->session->set_flashdata('success','L’utilisation de ce service a été arrêter');
            // add log
        } else {
            $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
        }
        redirect(site_url('fixer/'));
    }


    function actif_service($id=0)
    {
        if($this->item->actif_service($id)) {
            $this->session->set_flashdata('success','L’utilisation de ce service est déjà opérationnel et visible sur la plateforme');
            // add log
        } else {
            $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
        }
        redirect(site_url('fixer/'));
    }


    function hidden_service($id=0)
    {
        if($this->item->hidden_service($id)) {
            $this->session->set_flashdata('success','L’utilisation de ce service a été bloqué');
            // add log
        } else {
            $this->session->set_flashdata('error', 'Une erreur de système du à l’internet s\'est produite. Veuillez contacter votre administrateur ou réessayer plustard');
        }
        redirect(site_url('fixer/'));
    }











}
?>