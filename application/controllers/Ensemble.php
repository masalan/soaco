<?php
require_once('Main.php');

class Ensemble extends Main
{
    function __construct()
    {
        parent::__construct( NO_ACCESS_CONTROL );
        $this->load->library('common');

    }

    function index($data_id = 0)
    {
        //$station_id = url_decode($data_id);

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;  // Station ID
        $chart = $this->item->get_data()->result();
        $data['data'] = json_encode($chart);

        $total['produit_gasoil'] = $this->item->count_sell_fluid_log($station_id,2)->result();
        $total['produit_petrole'] = $this->item->count_sell_fluid_log($station_id,3)->result();
        $total['produit_gaz'] = $this->item->count_sell_fluid_log($station_id,4)->result();
        $total['produit_kerosene'] = $this->item->count_sell_fluid_log($station_id,3)->result();
        $total['produit_fuel'] = $this->item->count_sell_fluid_log($station_id,6)->result();

        $data['secure_code']   = $this->item->get_secure_code($station_id,7,$this->uri->segment(3));


        // raavitaillement Logs
        $pages = $this->config->item('pagination');
        $pages['base_url'] = site_url('items/index');
        $pages['total_rows'] = $this->item->count_all_ravit_log($station_id,1);
        $data['ravit_logs'] = $this->item->get_all_ravit_log($station_id, $pages['per_page'], $this->uri->segment(3));
        $data['pag'] = $pages;



        // Essence
        $page_ess = $this->config->item('pagination');
        $page_ess['base_url'] = site_url('ensemble/index');
        $page_ess['total_rows'] = $this->item->count_all_essence_sell($station_id,1,0);
        $data['ess_logs'] = $this->item->get_all_ess_log_oil($station_id,1,0, $page_ess['per_page'], $this->uri->segment(3));
        $data['ess_page'] = $page_ess;


        // Gasoil
        $page_gas = $this->config->item('pagination');
        $page_gas['base_url'] = site_url('ensemble/index');
        $page_gas['total_rows'] = $this->item->count_all_essence_sell($station_id,2,0);
        $data['gass_logs'] = $this->item->get_all_ess_log_oil($station_id,2,0, $page_gas['per_page'], $this->uri->segment(3));
        $data['gass_page'] = $page_gas;

        // Petrole
        $page_pet = $this->config->item('pagination');
        $page_pet['base_url'] = site_url('ensemble/index');
        $page_pet['total_rows'] = $this->item->count_all_essence_sell($station_id,5,0);
        $data['pet_logs'] = $this->item->get_all_ess_log_oil($station_id,5,0, $page_pet['per_page'], $this->uri->segment(3));
        $data['pet_page'] = $page_pet;

        // 65
        $page_65 = $this->config->item('pagination');
        $page_65['base_url'] = site_url('ensemble/index');
        $page_65['total_rows'] = $this->item->count_all_essence_sell($station_id,65,1);
        $data['sf_logs'] = $this->item->get_all_ess_log_oil($station_id,65,1, $page_65['per_page'], $this->uri->segment(3));
        $data['sf_page'] = $page_65;

        // 66
        $page_66 = $this->config->item('pagination');
        $page_66['base_url'] = site_url('ensemble/index');
        $page_66['total_rows'] = $this->item->count_all_essence_sell($station_id,66,1);
        $data['ss_logs'] = $this->item->get_all_ess_log_oil($station_id,66,1, $page_66['per_page'], $this->uri->segment(3));
        $data['ss_page'] = $page_66;

        // 612
        $page_612 = $this->config->item('pagination');
        $page_612['base_url'] = site_url('ensemble/index');
        $page_612['total_rows'] = $this->item->count_all_essence_sell($station_id,612,1);
        $data['sot_logs'] = $this->item->get_all_ess_log_oil($station_id,612,1, $page_612['per_page'], $this->uri->segment(3));
        $data['sot_page'] = $page_612;

        // 652
        $page_652 = $this->config->item('pagination');
        $page_652['base_url'] = site_url('ensemble/index');
        $page_652['total_rows'] = $this->item->count_all_essence_sell($station_id,652,1);
        $data['sft_logs'] = $this->item->get_all_ess_log_oil($station_id,612,1, $page_612['per_page'], $this->uri->segment(3));
        $data['sft_page'] = $page_652;


        $this->session->unset_userdata('searchterm');
        $pag = $this->config->item('pagination');
        $pag['base_url']   = site_url('soaco_e-Station');
        $pag['total_rows'] = $this->item->count_all_fluid_log();
        $data['selling']   = $this->item->get_all_fluid_log(7,$this->uri->segment(3)); // $pag['per_page']
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
        $data['societe'] = $this->user->get_one_company_info($company_id); // One company
        $data['station'] = $this->item->get_station_info($station_id); // One station



        $data['page_title'] = 'Gestion de Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/ensemble',$data);
        $this->load->view('layout/themes/footer',$data);

    }



}
?>