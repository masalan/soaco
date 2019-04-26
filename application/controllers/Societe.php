<?php
require_once('Main.php');

class Societe extends Main
{
    function __construct()
    {
        parent::__construct('societe');
        $this->load->library('uploader');
        $this->load->helper('string');

    }

    function index()
    {
        $this->session->unset_userdata(array(
            "searchterm" => "",
            "sub_cat_id" => "",
            "cat_id" => ""
        ));
        $pag = $this->config->item('pagination');
        $pag['base_url'] = site_url('items/index');
        $pag['total_rows'] = $this->user->count_all($this->get_current_city()->id);
        $data['items'] = $this->user->get_all_company( $pag['per_page'], $this->uri->segment(3));

        $data['pag'] = $pag;
        $content['content'] = $this->load->view('societe/list', $data, true);
        $this->load_template($content);



    }

    /***
     *  Add a company
     */
    function add()
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('add');
        }
        if ($this->input->server('REQUEST_METHOD')=='POST') {

//            // server side validation
//            if ( ! $this->is_valid_input()) {
//                redirect( site_url( 'societe/add' ));
//            }

            $user_data = array(
                'fullname'            => htmlentities($this->input->post('name')),
                'phone'               => htmlentities($this->input->post('phone')),
                'user_email'          => htmlentities($this->input->post('user_email')),
                'user_name'           => htmlentities($this->input->post('phone')),
                'arrondissement_id'   => htmlentities($this->input->post('sub_cat_id')),
                'ifu'                 => htmlentities($this->input->post('ifu')),
                'rccm'                => htmlentities($this->input->post('rccm')),
                'idus'                => htmlentities($this->input->post('idus')),
                'cat_id'              => htmlentities($this->input->post('cat_id')),
                'sub_cat_id'          => htmlentities($this->input->post('sub_cat_id')),
                'twon_id'             => htmlentities($this->input->post('twon_id')),
                'address'             => htmlentities($this->input->post('address')),
                'about_me'            => htmlentities($this->input->post('about_me')),
                'city_id'             => htmlentities($this->input->post('city_id')),
                'lat'                 => htmlentities($this->input->post('lat')),
                'lng'                 => htmlentities($this->input->post('lng')),
                'search_tag'          => htmlentities($this->input->post('search_tag')),
                'user_pass'           => md5($this->input->post('user_password')),
                'owner_name'          => htmlentities($this->input->post('owner_name')),
                'country_id'          => htmlentities($this->input->post('country_id')),
                'is_city_admin'       => 2,  // 2 Chef company
                'role_id'             => 7,   // company
                'status'             => 0,   // Licence Should active this one
                'is_gerant'          => 2
            );

            if ($this->user->save_company($user_data)) {
                $activities = array(
                    'user_id'        => $this->session->userdata('user_id'),
                    'id_item'        => $user_data['user_id'],
                    'nom_item'       => htmlentities($this->input->post('name')),
                    'depart_id'      => htmlentities($this->city->get_current_city()->id),
                    'com_id'         => htmlentities($this->input->post('cat_id')),
                    'arr_id'         => htmlentities($this->input->post('sub_cat_id')),
                    'name'           => 'Creation d`une sociétè',
                    'description'    => 'Creation d`un sociétè',
                    'type'           => '1',
                    'added'          => date("Y-m-d H:i:s"),
                    'role_id'        => '7' );
                $this->user->log_action($activities);

                $this->session->set_flashdata('success','La sociétè est ajouté avec succès.');
            } else {
                $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
            }
            redirect(site_url('societe'));
        }
        $content['content'] = $this->load->view('societe/add',array(),true);
        $this->load_template($content);
    }



    function add_a()
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('add');
        }
        $action = "save";
        unset($_POST['save']);
        if (htmlentities($this->input->post('gallery'))) {
            $action = "gallery";
            unset($_POST['gallery']);
        }
        if ($this->input->server('REQUEST_METHOD')=='POST') {

            // server side validation
//            if ( ! $this->is_valid_input()) {
//                redirect( site_url( 'societe/add' ));
//            }

            $item_data = $this->input->post();

            $temp = array();
            foreach ( $item_data as $key => $value ) {
                $temp[$key] = $value;
            }
            $item_data = $temp;
            $item_data['city_id'] = $this->get_current_city()->id;
            $item_data['is_published'] = 1;
            //unset($item_data['cat_id']);
            unset($item_data['find_location']);

            if ($this->societe->save($item_data)) {
                $this->session->set_flashdata('success','La Société est ajoutée avec succès.');
            } else {
                $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
            }
            /****
            if ($action == "gallery") {
                redirect(site_url('societe/gallery/'.$item_data['id']));
            } else {
                redirect(site_url('societe'));
            }
            ****/
            redirect(site_url('societe'));

        }
        $cat_count = $this->category->count_all($this->get_current_city()->id);
        $sub_cat_count = $this->sub_category->count_all($this->get_current_city()->id);

        if($cat_count <= 0 && $sub_cat_count <= 0) {
            $this->session->set_flashdata('error','Oops! Veuillez créer d`abord la Commune et l`Arrondissement avant de créer les stations.');
            redirect(site_url('societe'));
        } else {
            if($cat_count <= 0) {
                $this->session->set_flashdata('error','Oops! Veuillez créer la Commune d`abord avant de créer les station.');
                redirect(site_url('societe'));
            } else if ($sub_cat_count <= 0) {
                $this->session->set_flashdata('error','Oops! Veuillez créer les arrondissement d`abord avant de créer les station.');
                redirect(site_url('societe'));
            }
        }
        $content['content'] = $this->load->view('societe/add',array(),true);
        $this->load_template($content);
    }


    /**
     *  UPDATE Company
     * @param int $data_id
     */
    function edit($data_id=0)
    {
        $user_id = url_decode($data_id);

        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }

        if ($this->input->server('REQUEST_METHOD')=='POST') {

            if ($this->user->get_logged_in_user_info()->user_id != $user_id &&
                $this->user->get_info($user_id)->is_owner == 1) {
                $this->session->set_flashdata('error','Vous ne pouvez pas modifier l`administrateur de la plateforme.');
            } else {
                $user_data = array(
                    'arrondissement_id' => htmlentities($this->input->post('sub_cat_id')),
                    'fullname'          => htmlentities($this->input->post('name')),
                    'phone'             => htmlentities($this->input->post('phone')),
                    'user_email'        => htmlentities($this->input->post('user_email')),
                    'user_name'         => htmlentities($this->input->post('phone')),
                    'country_id'        => htmlentities($this->input->post('country_id')),
                    'cat_id'            => htmlentities($this->input->post('cat_id')),
                    'sub_cat_id'        => htmlentities($this->input->post('sub_cat_id')),
                    'twon_id'           => htmlentities($this->input->post('twon_id')),
                    'address'           => htmlentities($this->input->post('address')),
                    'about_me'          => htmlentities($this->input->post('about_me')),
                    'lat'               => htmlentities($this->input->post('lat')),
                    'lng'               => htmlentities($this->input->post('lng')),
                    'ifu'               => htmlentities($this->input->post('ifu')),
                    'rccm'              => htmlentities($this->input->post('rccm')),
                    'idus'              => htmlentities($this->input->post('idus')),
                    'search_tag'        => htmlentities($this->input->post('search_tag')),
                    'owner_name'        => htmlentities($this->input->post('owner_name')),
                    'user_pass'         => md5($this->input->post('user_password')),
                    'updated'           => time(),
                    'is_city_admin'     => 2,  // 2 Chef company
                    'role_id'           => 7,
                    'is_gerant'         => 2
                );

                if(!htmlentities($this->input->post('is_published'))) {
                    $user_data['is_published'] = 0;
                }

                //If new user password exists,change password
                if ($this->input->post('user_pass')!='') {
                    $user_data['user_pass'] = md5($this->input->post('user_pass'));
                }

           if ($this->user->save_company($user_data,$user_id)) {
               // Activities Log
               $activities = array(
                   'user_id'        => $this->session->userdata('user_id'),
                   'id_item'        => $user_id,
                   'nom_item'       => htmlentities($this->input->post('name')),
                   'depart_id'      => htmlentities($this->city->get_current_city()->id),
                   'com_id'         => htmlentities($this->input->post('cat_id')),
                   'arr_id'         => htmlentities($this->input->post('sub_cat_id')),
                   'name'           => 'Modification de la  sociétè',
                   'description'    => 'Modification de la sociétè',
                   'type'           => '',
                   'added'          => date("Y-m-d H:i:s"),
                   'role_id'        => '7'
               );
               $this->user->log_action($activities);

               // Update Licence or Add
               $add_licence = array(
                   'licence_admin_id'        => $this->session->userdata('user_id'),
                   'licence_idus'             => htmlentities($this->input->post('idus')),
                   'licence_company_id'      => $user_id,
                   'licence_name'            => htmlentities($this->input->post('name')),
                   'licence_start_time'      => date("Y-m-d H:i:s"),
                   'licence_end_time'        => date("Y-m-d H:i:s"),
                   //'licence_created'         => date("Y-m-d H:i:s"),
                   'licence_updated'         => date("Y-m-d H:i:s"),
                   'licence_is_live'         => '1'
               );
               $this->user->company_licence($add_licence,$user_id);


                        $this->session->set_flashdata('success','la Société a ete mise a jour.');
                } else {
                    $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
                }
            }
            redirect(site_url('societe'));
        }
        $data['item'] = $this->user->get_company_info($user_id);
        $content['content'] = $this->load->view('societe/edit',$data,true);
        $this->load_template($content);
    }

    function edit_3($data_id=0)
    {
        $item_id = url_decode($data_id);
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }
        if ($this->input->server('REQUEST_METHOD')=='POST') {

            // server side validation
            if ( ! $this->is_valid_input( $item_id )) {
                redirect( site_url( 'societe/edit/' . $item_id ));
            }

            $item_data = $this->input->post();
            $temp = array();
            foreach ( $item_data as $key => $value ) {
                $temp[$key] = $value;
            }
            $item_data = $temp;
            if(!htmlentities($this->input->post('is_published'))) {
                $item_data['is_published'] = 0;
            }
            unset($item_data['find_location']);
            if ($this->item->save($item_data, $item_id)) {
                $this->session->set_flashdata('success','La station est mise à jour avec succès.');
            } else {
                $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
            }
            redirect(site_url('societe'));
        }
        $data['item'] = $this->user->get_company_info($item_id);
        $content['content'] = $this->load->view('societe/edit',$data,true);
        $this->load_template($content);
    }



    function search()
    {
        $search_arr = array(
            "searchterm" => htmlentities($this->input->post('searchterm')),
            "sub_cat_id" => htmlentities($this->input->post('sub_cat_id')),
            "cat_id" => htmlentities($this->input->post('cat_id'))
        );

        $search_term = $this->searchterm_handler($search_arr);
        $data = $search_term;

        $pag = $this->config->item('pagination');

        $pag['base_url'] = site_url('societe/search');
        $pag['total_rows'] = $this->item->count_all_by($this->get_current_city()->id, $search_term);

        $data['societe'] = $this->item->get_all_by($this->get_current_city()->id, $search_term, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        $content['content'] = $this->load->view('societe/search',$data,true);

        $this->load_template($content);
    }

    function searchterm_handler($searchterms = array())
    {
        $data = array();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            foreach ($searchterms as $name=>$term) {
                if ($term && trim($term) != " ") {
                    $this->session->set_userdata($name,$term);
                    $data[$name] = $term;
                } else {
                    $this->session->unset_userdata($term);
                    $data[$name] = "";
                }
            }
        } else {
            foreach ($searchterms as $name=>$term) {
                if ($this->session->userdata($name)) {
                    $data[$name] = $this->session->userdata($name);
                } else {
                    $data[$name] = "";
                }
            }
        }

        return $data;
    }


    function gallery($id)
    {
        session_start();
        $_SESSION['parent_id'] = $id;
        $_SESSION['type'] = 'item';
        $content['content'] = $this->load->view('societe/gallery', array('id' => $id), true);

        $this->load_template($content);
    }

    function upload($item_id=0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }

        $upload_data = $this->uploader->upload($_FILES);

        if (!isset($upload_data['error'])) {
            foreach ($upload_data as $upload) {
                $image = array(
                    'item_id'  => $item_id,
                    'path'     => $upload['file_name'],
                    'width'    => $upload['image_width'],
                    'height'   => $upload['image_height'],
                    'city_id'  => $this->get_current_city()->id
                );
                $this->image->save($image);
            }
        } else {
            $data['error'] = $upload_data['error'];
        }

        $data['item'] = $this->item->get_info($item_id);

        $content['content'] = $this->load->view('societe/edit',$data,true);

        $this->load_template($content);
    }

    function publish($id = 0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('publish');
        }

        $item_data = array(
            'is_published'=> 1
        );

        if ($this->item->save($item_data, $id)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function unpublish($id = 0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('publish');
        }

        $item_data = array(
            'is_published'=> 0
        );

        if ($this->item->save($item_data, $id)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }



    function publish_company($id = 0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('publish');
        }

        $item_data = array(
            'is_published'=> 1
        );

        if ($this->user->save_like($item_data, $id)) {
            $activities = array(
                'user_id'        => $this->session->userdata('user_id'),
                'id_item'        => $id,
                'nom_item'       => '',
                'depart_id'      => '',
                'com_id'         => '',
                'arr_id'         => '',
                'name'           => 'Rendre active la societe',
                'description'    => 'Rendre active la societe',
                'type'           => '1',
                'added'          => date("Y-m-d H:i:s"),
                'role_id'        => ''
            );
            $this->user->log_action($activities);
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function unpublish_company($id = 0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('publish');
        }

        $item_data = array(
            'is_published'=> 0
        );

        if ($this->user->save_like($item_data, $id)) {
            $activities = array(
                'user_id'        => $this->session->userdata('user_id'),
                'id_item'        => $id,
                'nom_item'       => '',
                'depart_id'      => '',
                'com_id'         => '',
                'arr_id'         => '',
                'name'           => ' Desactiver la societe',
                'description'    => ' Desactiver la societe',
                'type'           => '1',
                'added'          => date("Y-m-d H:i:s"),
                'role_id'        => ''
            );
            $this->user->log_action($activities);

            echo 'true';
        } else {
            echo 'false';
        }
    }

    function delete($user_id=0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('delete');
        }
        if ($this->user->get_logged_in_user_info()->user_id == $user_id) {
            $this->session->set_flashdata('error','You can\'t delete yourself.');
        } else if ($this->user->get_info($user_id)->is_owner == 1) {
            $this->session->set_flashdata('error','You can\'t delete site owner.');
        } else {
            if ($this->user->delete($user_id)) {
                $activities = array(
                    'user_id'        => $this->session->userdata('user_id'),
                    'id_item'        => $user_id,
                    'nom_item'       => htmlentities($this->input->post('name')),
                    'depart_id'      => htmlentities($this->city->get_current_city()->id),
                    'com_id'         => htmlentities($this->input->post('cat_id')),
                    'arr_id'         => htmlentities($this->input->post('sub_cat_id')),
                    'name'           => 'Suppression de la  sociétè',
                    'description'    => 'Suppression de la sociétè',
                    'type'           => '',
                    'added'          => date("Y-m-d H:i:s"),
                    'role_id'        => '7'
                );
                $this->user->log_action($activities);

                $this->session->set_flashdata('success','La société a été supprimée avec succès.');
            } else {
                $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
            }
        }
        redirect(site_url('societe'));
    }

    /**
     * Delete Company Ok
     * @param $user_id
     */
    function delete_company($user_id)
    {
        $delete = $this->db->delete('be_users', array('user_id' => $user_id));
        if ($delete) {
            $activities = array(
                'user_id'        => $this->session->userdata('user_id'),
                'id_item'        => $user_id,
                'nom_item'       => htmlentities($this->input->post('name')),
                'depart_id'      => htmlentities($this->city->get_current_city()->id),
                'com_id'         => htmlentities($this->input->post('cat_id')),
                'arr_id'         => htmlentities($this->input->post('sub_cat_id')),
                'name'           => 'Suppression de la  sociétè',
                'description'    => 'Suppression de la sociétè',
                'type'           => '',
                'added'          => date("Y-m-d H:i:s"),
                'role_id'        => '7'
            );
            $this->user->log_action($activities);
            $this->session->set_flashdata('success','La société a été supprimée avec succès.');
        } else {
            $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
        }
        redirect(site_url('societe'));
    }



    function delete_image($item_id, $image_id, $image_name)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }

        if ($this->image->delete($image_id)) {
            $this->delete_images( $image_name );
            $this->session->set_flashdata('success','L\'image est supprimé avec succès.');
        } else {
            $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
        }
        redirect(site_url('societe/edit/'.$item_id));
    }

    /**
     * Commmune Liste
     * @param $cat_id
     */
    function get_com_list($city_id)
    {
        $query = $this->db->get_where('cd_categories' , array('city_id'=>$city_id,'is_published' =>1));
        echo json_encode($query->result());
    }

    /**
     * Arrondissement List
     * @param $cat_id
     */
    function get_sub_cats($cat_id)
    {
        $sub_categories = $this->sub_category->get_all_by_cat_id($cat_id);
        echo json_encode($sub_categories->result());
    }

    /**
     * Station List
     * @param $cat_id
     */
    function get_station($cat_id)
    {
        // $sub_categories = $this->sub_category->get_all_by_cat_id($cat_id);
        $query = $this->db->get_where('cd_items' , array('sub_cat_id'=>$cat_id,'is_published' =>1));
        echo json_encode($query->result());
    }


    /***
     * Quartier
     * @param $data_id
     */
    function get_quartier_station($data_id)
    {
        $query = $this->db->get_where('quartier' , array('is_published' =>1));
        echo json_encode($query->result());
    }

    /**
     * @param $cat_id
     */
    function get_quartier($cat_id)
    {
        $arr = $this->db->get_where('cd_twon', array('cd_commune_id'=>$cat_id));
        echo json_encode($arr->result());
    }


    function exists( $item_id = 0)
    {
        $name = trim($_REQUEST['name']);
        $sub_cat_id = $_REQUEST['sub_cat_id'];

        if (trim(strtolower($this->item->get_info($item_id)->name)) == strtolower($name)) {
            echo "true";
        } else if($this->item->exists(array(
            'name'=> $name,
            'sub_cat_id' => $sub_cat_id
        )))
        {
            echo "false";
        } else {

            echo "true";
        }
    }

    /**
     * Determines if valid input.
     *
     * @param      integer|string  $item_id  The item identifier
     *
     * @return     boolean         True if valid input, False otherwise.
     */
    function is_valid_input( $item_id = 0 )
    {
        $rule = 'trim|required|min_length[3]|callback_is_valid_name['. $item_id  .']';

       // $this->form_validation->set_rules('name', 'Name', $rule );
      //  $this->form_validation->set_rules('unit_price', 'Price', 'is_natural_no_zero' );

        if ( $this->form_validation->run() == FALSE ) {
            $this->session->set_flashdata('error', validation_errors());
            return false;
        }

        return true;
    }

    /**
     * Determines if valid name.
     *
     * @param      <type>   $name     The name
     * @param      integer  $item_id  The item identifier
     *
     * @return     boolean  True if valid name, False otherwise.
     */
    function is_valid_name( $name, $item_id = 0 )
    {
        $sub_cat_id = $_REQUEST['sub_cat_id'];

        if ( trim( strtolower( $this->item->get_info( $item_id )->name )) == strtolower( $name )) {

            return true;
        } else if( $this->item->exists( array( 'name'=> $name, 'sub_cat_id' => $sub_cat_id )))  {

            $this->form_validation->set_message('is_valid_name', 'Le nom existe déjà dans le système');
            return false;
        } else {

            return true;
        }
    }
}
?>