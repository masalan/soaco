<?php
class Login_station extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");


        $this->load->library('email',array('mailtype'  => 'html', 'newline'   => '\r\n'));
        $this->load->library('uploader');

        if ( isset( $_GET['url'] )) {
            // if source url is existed, that url need to be redirected after login
            $this->session->set_userdata( 'source_url', $_GET['url'] );
        }
    }



    function login()
    {
        $data['page_title'] = 'SOACO e-Station | Connexion a ma Station';

            if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

                $pseudo = htmlentities($this->input->post('pseudo'));
                $password = $this->input->post('password');

                if ($this->get_login($pseudo,$password)) {

                    $admin_url = site_url('soaco');
                    $conds = array('admin_id' => $this->user->get_logged_in_user_info()->user_id, 'is_approved' => 1);
                    /* find the approved Dpt and redirect */
                    $approved_cities = $this->city->get_all_by($conds)->result();


                     if ($this->session->userdata('role_id') == 1)
                         redirect($admin_url,'refresh');

                    if ($this->session->userdata('role_id') == 2)
                        redirect(site_url( "manager/" . url_encode($approved_cities[0]->id)), 'refresh');

                    if ($this->session->userdata('role_id') == 3)
                        redirect(site_url( "manager/"), 'refresh');

                    if ($this->session->userdata('role_id') == 4)
                        redirect(site_url( "manager/" . url_encode($approved_cities[0]->id)), 'refresh');

                    if ($this->session->userdata('role_id') == 5)
                        redirect(site_url('soaco_e-Station/'.url_encode($this->user->get_logged_in_user_info()->user_id)), 'refresh');

                    if ($this->session->userdata('role_id') == 6)
                        redirect(site_url('soaco_e-Station/'.url_encode($this->user->get_logged_in_user_info()->user_id)), 'refresh');

                    if ($this->session->userdata('role_id') == 7)
                        redirect(site_url('company/'.url_encode($this->user->get_logged_in_user_info()->user_id)), 'refresh');

                }else {
                    // if credential is incorrect, show error message and redirect to login
                    $this->session->set_flashdata('error','Connexion refusée. Nom de compte ou mot de passe incorrect');
                    redirect(site_url('station'));
                }




            } else {
                // if request is GET method, load login form
                $this->load->view('login_station',$data);
            }





    }


    /**
     *  Log Out
     */
    function logout()
    {
        $this->station_logout();
        redirect(site_url('station'), 'refresh');
    }










    function get_login($pseudo, $user_pass)
    {
        /* FIND USER IN SYSTEM USER TABLE */
        $is_frontend_user = false;

        $conds = array('user_name' => $pseudo, 'user_pass' => md5($user_pass), 'status' => 1);
        $query = $this->db->get_where('be_users', $conds,1);
        if ($query->num_rows() == 0 ) {
            return false;
        }

        $row = $query->row();
        /* SYSTEM USER AND CITY ADMIN INFORMATION */
        $user_id = ( $is_frontend_user )? $row->id: $row->user_id;
        $is_owner = ( $is_frontend_user )? 0: $row->is_owner;
        $role_id = ( $is_frontend_user )? 0: $row->role_id;
        $company_id = ( $is_frontend_user )? 0: $row->company_id;
        $station_id = ($is_frontend_user )? 0: $row->station_id;     // Station ID
        $city_id = ($is_frontend_user )? 0: $row->city_id;           // city ID  country_id
        $country_id = ($is_frontend_user )? 0: $row->country_id;     // Pays ID
        $cat_id = ($is_frontend_user )? 0: $row->cat_id;             // commune ID
        $sub_cat_id = ($is_frontend_user )? 0: $row->sub_cat_id;     // Arrondissement ID
        $twon_id = ($is_frontend_user )? 0: $row->twon_id;            // Quartier ID

        $fullname = ( $is_frontend_user )? $row->id: $row->fullname;
        $profile_photo = ($is_frontend_user )? $row->profile_photo: $row->profile_photo;
        $phone = ($is_frontend_user )? $row->phone: $row->phone;
        $user_name = ( $is_frontend_user )? $row->user_name: $row->user_name;

        $allow_city_id = 0;
        $is_city_admin = 0;


        /* CITY ADMIN INFORMATION */
        if ( !$is_frontend_user ) {
            if ( $row->is_city_admin ) {
                // get the city that user can manager
                $city_query = $this->db->get_where('cd_cities', array('admin_id' => $row->user_id ));
                $city_id = 0;
                if ( $city_query->num_rows() > 0 ) {
                    $city = $city_query->row();
                    $city_id = $city->id;
                }
                $allow_city_id = $city_id;
                $is_city_admin = true;
            }
        }

        /* SESSION VARIABLES */
        $this->session->set_userdata('user_id', $user_id );
        $this->session->set_userdata('is_owner', $is_owner );
        $this->session->set_userdata('role_id', $role_id );
        $this->session->set_userdata('allow_city_id', $allow_city_id );
        $this->session->set_userdata('is_city_admin', $is_city_admin );
        $this->session->set_userdata('station_id', $station_id);
        $this->session->set_userdata('company_id', $company_id);
        $this->session->set_userdata('fullname', $fullname );
        $this->session->set_userdata('profile_photo', $profile_photo );
        $this->session->set_userdata('phone', $phone );
        $this->session->set_userdata('user_name', $user_name );
        $this->session->set_userdata('city_id', $city_id );       // Departement
        $this->session->set_userdata('cat_id', $cat_id );         // Departement
        $this->session->set_userdata('country_id', $country_id );       // Country ID
        $this->session->set_userdata('sub_cat_id', $sub_cat_id );
        $this->session->set_userdata('twon_id', $twon_id );           // Quartier ID


        return true;
    }


    function  station_logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('is_owner');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('allow_city_id');
        $this->session->unset_userdata('is_city_admin');
        $this->session->unset_userdata('is_frontend_user');
        $this->session->unset_userdata('station_id');
        $this->session->unset_userdata('source_url');
        redirect(site_url('station'),'refresh');
    }

    function is_logged_in()
    {
        return $this->session->userdata('user_id')!=false;
    }

    function is_frontend_user()
    {
        return ($this->session->userdata('is_frontend_user'));
    }





}
?>