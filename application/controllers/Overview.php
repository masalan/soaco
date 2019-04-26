<?php
require_once('Main.php');

class Overview extends CI_Controller
{
    function __construct()
    {
        parent::__construct( ONLY_LOGIN_CONTROL );
        $this->load->library('session');

        $this->load->library('common');
        $this->load->library('uploader');

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        // if user has not login
        if (!$this->user->is_logged_in()) {
            redirect(site_url('login'));
        }
    }

    function index($data_id = 0)
    {
        $company = url_decode($data_id);

        if ($this->session->userdata('role_id') == 1)
            redirect(site_url('exit'), 'refresh');

        if ($this->session->userdata('role_id') == 2)
            redirect(site_url('exit'), 'refresh');

        if ($this->session->userdata('role_id') == 3)
            redirect(site_url('exit'), 'refresh');
        if ($this->session->userdata('role_id') == 4)
            redirect(site_url('exit'), 'refresh');

        if ($this->session->userdata('role_id') == 5)
            redirect(site_url('exit'), 'refresh');

        if ($this->session->userdata('role_id') == 6)
            redirect(site_url('exit'), 'refresh');
        if ($this->session->userdata('role_id') != 7)  // Beware
            redirect(site_url('exit'), 'refresh');

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;

        $data['msg']   = $this->inquiry->get_all_msg_from_station($this->user->get_logged_in_user_info()->user_id,15,$this->uri->segment(3));
        $company_id = $this->user->get_logged_in_user_info()->user_id;

        // activity sell
        $data['activite'] = $this->item->get_historic_sell_company($company_id,7);
        $data['societe'] = $this->user->get_company_data($this->user->get_logged_in_user_info()->user_id); // One company

        // Vente journaliere liste
        $data['selling']   = $this->item->get_all_selling_today($company_id,7,$this->uri->segment(3)); // $pag['per_page']

        // raavitaillement Logs
        $pages = $this->config->item('pagination');
        $pages['base_url'] = site_url('items/index');
        $pages['total_rows'] = $this->item->count_all_station_ravit($company_id,1);
        $data['ravit_logs'] = $this->item->get_all_station_ravit($company_id, 7, $this->uri->segment(3));
        $data['pag'] = $pages;

        // Liste des stations
        $data['items'] = $this->item->list_station($company_id);
        $demo = $this->item->get_range_selling(1,$company_id)->row()->quantity_out?:0;

        // var_dump( $data['items']);
       //  exit();

        /********************* Display Zones ****************************/

        $this->session->unset_userdata('city_id');
        $cities = array();
        if ($this->input->server('REQUEST_METHOD')=='POST') {
            $searchterm = htmlentities($this->input->post('searchterm'));
            if ( $this->user->is_system_user() ) {
                $cities = $this->city->get_all_zone_by( array('searchterm' => $searchterm, 'is_approved' => APPROVE))->result();
            } else {
                $cities = $this->city->get_all_zone_by( array('searchterm' => $searchterm, 'admin_id' => $this->user->get_logged_in_user_info()->user_id,'is_approved' => APPROVE))->result();}

            $data['searchterm'] = $searchterm;
        } else {
            if ( $this->user->is_system_user() ) {
                $cities = $this->city->get_all_zones( array() )->result();
            } else {
                $cities = $this->city->get_all_zone_by( array('admin_id' => $this->user->get_logged_in_user_info()->user_id,'is_approved' => APPROVE))->result();}
        }

        // 		$this->db->where('country_id',$this->session->userdata('country_id'));

        $temp_cities_arr = array();
        foreach ($cities as $city) {
            $img = $this->image->get_all_by_type($city->id, 'city')->result();

            if ( count( $img ) > 0 ) {
                $city->image = $img[0]->path;
            } else {
                $city->image = "";
            }
            $temp_cities_arr[] = $city;
        }
        $data['cities'] = $temp_cities_arr;

        /********************* End Display Zones ****************************/


        $data['page_title'] = 'SOACO | Comapny manager';
        $this->load->view('company/theme/header',$data);
        $this->load->view('company/theme/nav',$data);
        $this->load->view('company/overview_a',$data);
        $this->load->view('company/theme/footer',$data);
    }







}
?>