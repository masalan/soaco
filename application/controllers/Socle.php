<?php
require_once('Main.php');

class Socle extends CI_Controller
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
        $data['city_id'] = url_decode($data_id);  // city ID
        $city_id = url_decode($data_id);
        $data['company_id'] = $this->user->get_logged_in_user_info()->user_id;
        // var_dump($data['company_id']);
        // exit();

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

        $data['msg']   = $this->inquiry->get_all_msg_from_zone($this->user->get_logged_in_user_info()->user_id,$city_id,15,$this->uri->segment(3));
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
        $data['items'] = $this->item->list_station_by_zone($company_id,$city_id,15);
        $demo = $this->item->get_range_selling(1,$company_id)->row()->quantity_out?:0;

        // var_dump(($this->user->get_logged_in_user_info()->user_id));
       //  exit();

        $data['page_title'] = 'SOACO | Comapny manager';
        $this->load->view('company/theme/header',$data);
        $this->load->view('company/theme/nav',$data);
        $this->load->view('company/socle',$data);
        $this->load->view('company/theme/footer',$data);

    }




    function read($id = 0,$city_id = 0)
    {

        $query    = $this->db->get_where('cd_items', array('id' => $id, 'is_published' => 1));  // Station fetch
        if ($query->num_rows() > 0) {
            $row           = $query->row();
            $city_id       = $row->city_id;
        }

        $data = array('is_read'=> 1,"updated" => time(),'city_id'=>$city_id);

        if ($this->item->save_action($data, $id)) {
            redirect(site_url('zone_details/').url_encode($city_id));
        } else {
            redirect(site_url('zone_details/').url_encode($city_id));
        }
        redirect(site_url('zone_details/').url_encode($city_id));
    }

    function unread($id = 0,$city_id = 0)
    {
        $query    = $this->db->get_where('cd_items', array('id' => $id, 'is_published' => 1));  // Station fetch
        if ($query->num_rows() > 0) {
            $row           = $query->row();
            $city_id       = $row->city_id;
        }
        $data = array('is_read'=> 0,"updated" => time(),'city_id'=>$city_id);

        if ($this->item->save_action($data, $id)) {
            redirect(site_url('zone_details/').url_encode($city_id));
        } else {
            redirect(site_url('zone_details/').url_encode($city_id));
        }
        redirect(site_url('zone_details/').url_encode($city_id));
    }




    /**
     *  Station Active
     * @param int $id
     */
    function actif($id = 0,$city_id = 0)
    {
        $item_data = array('is_published'=> 1);
        if ($this->item->save($item_data, $id)) {
            redirect(site_url('zone_details/').url_encode($city_id));
        } else {
            redirect(site_url('zone_details/').url_encode($city_id));
        }
    }

    /**
     * Station desactive
     * @param int $id
     */
    function desactif($id = 0,$city_id = 0)
    {
        $item_data = array('is_published'=> 0);
        if ($this->item->save($item_data, $id)) {
            redirect(site_url('zone_details/').url_encode($city_id));
        } else {
            redirect(site_url('zone_details/').url_encode($city_id));
        }
    }








}
?>