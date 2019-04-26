<?php
require_once('Main.php');

class Statistiques extends Main
{
    function __construct()
    {
        parent::__construct( NO_ACCESS_CONTROL );
        $this->load->library('common');

    }

    function index($data_id = 0)
    {
        //$station_id = url_decode($data_id);
        $chart = $this->item->get_data()->result();
        $data['data'] = json_encode($chart);

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        $data['secure_code']   = $this->item->get_secure_code($station_id,7,$this->uri->segment(3));
        $this->session->unset_userdata('searchterm');
        $pag = $this->config->item('pagination');
        $pag['base_url']   = site_url('soaco_e-Station');
        $pag['total_rows'] = $this->item->count_all_fluid_log();
        $data['selling']   = $this->item->get_all_fluid_log($station_id,7,$this->uri->segment(3)); // $pag['per_page']
        $data['pag']       = $pag;
        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

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
        $data['gaz'] = $this->item->get_info_gaz(6,$station_id);
        $data['lubrifiant'] = $this->item->get_info_lubrifiants(7,$station_id);
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();

        $data['page_title'] = 'Statistiques de la Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/statistiques',$data);
        $this->load->view('layout/themes/footer',$data);

    }





}
?>