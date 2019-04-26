<?php
require_once('Main.php');

class Mail extends Main
{
    function __construct()
    {
        parent::__construct( NO_ACCESS_CONTROL );
        $this->load->library('common');

    }

    function index($data_id = 0)
    {
        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
       // $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3))->result();

        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('desk'));
        }

        $send_by_station = '1';
        $no_send_by_station = '0';
        $data['email']   = $this->item->get_all_msg($no_send_by_station,$station_id);
        $data['sent']   = $this->item->get_all_msg($send_by_station,$station_id);
        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant

        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $data['societe'] = $this->user->get_one_company_info($company_id); // One company
        $data['station'] = $this->item->get_station_info($station_id); // One station
        $data['station_id'] = $station_id;

        $data['page_title'] = 'Gestion de messages';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/mail',$data);
        $this->load->view('layout/themes/footer',$data);

    }




    function read($id = 0)
    {
        $data = array('is_read'=> 1,"updated" => time());
        if ($this->inquiry->save($data, $id)) {
            $this->session->set_flashdata('success','lu');
        } else {
            $this->session->set_flashdata('error', 'Database error occured.Please contact your system administrator.');
        }
        redirect(site_url('messages/'));
    }

    function unread($id = 0)
    {
        $data = array('is_read'=> 0,"updated" => time());
        if ($this->inquiry->save($data, $id)) {
            $this->session->set_flashdata('success','Non lu');
        } else {
            $this->session->set_flashdata('error', 'Database error occured.Please contact your system administrator.');
        }
        redirect(site_url('messages/'));
    }


    function is_read($id = 0)
    {
        $data = array(
            "updated" => time(),
            "is_read" => 1,
        );

        if ($this->inquiry->is_read($data,$id)) {
            $this->session->set_flashdata('success','The inquiry is successfully deleted.');
        } else {
            $this->session->set_flashdata('error', 'Database error occured.Please contact your system administrator.');
        }
        redirect(site_url('soaco_msg_vue/'.url_encode($id)));
    }










}
?>