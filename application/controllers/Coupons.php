<?php
require_once('Main.php');
class Coupons extends Main
{
    function __construct()
    {
        parent::__construct( NO_ACCESS_CONTROL );
        $this->load->library('uploader');
        $this->load->helper('string');

    }

    function index()
    {
        $this->session->unset_userdata('searchterm');

        $pag = $this->config->item('pagination');
        $pag['base_url'] = site_url('Coupons/index');
        $pag['total_rows'] = $this->category->count_all_cards();
       // $pag['total_rows'] = $this->category->count_all($this->get_current_city()->id);

        $data['categories'] = $this->category->get_all_cards($pag['per_page'],$this->uri->segment(3));
        $data['pag'] = $pag;

        $content['content'] = $this->load->view('coupons/list',$data,true);

        $this->load_template($content);
    }

    function add()
    {

        if ($this->input->server('REQUEST_METHOD')=='POST') {

            $cards_data = array(
                'card_serial' => htmlentities($this->input->post('card_serial')),
                'country_id' => htmlentities($this->input->post('country_id')),
                'name' => htmlentities( $this->input->post('name')),
                'type_cards_id' =>  htmlentities( $this->input->post('type_cards_id')),
                'initial_moeny' =>  htmlentities( $this->input->post('initial_moeny')),
                'company_id' =>  htmlentities( $this->input->post('company_id')),
                'username' =>  htmlentities( $this->input->post('username')),
                'currency_id' =>  htmlentities( $this->input->post('currency_id')),
                'phone' =>  htmlentities( $this->input->post('phone')),
                'add_date' => date("d-m-Y H:i:s"),
                'is_published' => 1
            );

            if ($this->category->save_cards($cards_data)) {

                $this->session->set_flashdata('success','La commune est ajoutée avec succès.');
            } else {
                $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
            }

            redirect(site_url('coupons'));

        }
        $content['content'] = $this->load->view('coupons/add',array(),true);
        $this->load_template($content);
    }


    /**
     * verification du coupon
     */
    function check_code()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $code = htmlentities($this->input->post('code'));
            $data = $this->code->check_coupon($code);

            if ($data->card_serial == "") {

                $this->session->set_flashdata('error','Le Numero de cette carte n`existe pas, reessayer.');

                redirect(site_url('code_card/'));

            }elseif ($data->is_published == 0){
                $this->session->set_flashdata('error','Votre carte est invalide');
                redirect(site_url('code_card/'));
            } else {
                if ($data->is_valid == 0) {
                    $this->session->set_flashdata('success','Votre carte est valide et prète a l`utilisation ');
                }
            }
            redirect(site_url('check_done/').url_encode($code));
        }

        $data['code'] = $code;
        $data['page_title'] = 'Gestion de carte | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/check_done',$data);
        $this->load->view('layout/themes/footer',$data);

    }


    function check_enter_code(){

        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('stock'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));


        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;

        $data['societe'] = $this->user->get_one_company_info($company_id); // One company

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;


        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();


        $data['page_title'] = 'Gestion de carte | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/check',$data);
        $this->load->view('layout/themes/footer',$data);

    }

    /**
     * Check Its OK
     */
    function check_done($erial_code){

        $code = url_decode($erial_code);


        $data['carte'] = $this->db->get_where('cd_cards',array('card_serial'=>$code))->row();


        $station_id = $this->db->get_where('be_users',array('user_id'=>$this->user->get_logged_in_user_info()->user_id))->row()->station_id;
        if ($station_id) {
            $this->session->set_userdata('station_id', $station_id);
            $this->session->set_userdata('action', 'city_list');
        }
        if (!$this->session->userdata('station_id')) {
            redirect(site_url('stock'));
        }

        $data['user'] = $this->user->get_info($this->user->get_logged_in_user_info()->user_id);  // One Gerant
        $data['station'] = $this->item->get_station_info($station_id); // One station

        // Get Log Sell Fluid
        $pag = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $pag['total_rows'] = $this->item->count_all_log($station_id,1);
        $data['fluid_logs'] = $this->item->get_all_log($station_id, $pag['per_page'], $this->uri->segment(3));
        $data['pag'] = $pag;

        // Messages
        $data['msg']   = $this->inquiry->get_all_msg_read($station_id,7,$this->uri->segment(3));


        $data['item'] = $this->item->get_info($station_id);
        $company_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->company_id;
        $country_id = $this->db->get_where('cd_items',array('id'=>$station_id))->row()->country_id;

        $data['societe'] = $this->user->get_one_company_info($company_id); // One company

        // Work Jauge
        $page = $this->config->item('pagination');
        $page['base_url'] = site_url('stock');
        $page['total_rows'] = $this->item->count_all_jauge($station_id,1);
        $data['jauge'] = $this->item->get_all_jauge($station_id, $page['per_page'], $this->uri->segment(3));
        $data['page'] = $page;


        $this->load->helper('number');
        $data['essence'] = $this->item->get_info_essence($country_id,$station_id);
        $data['gasoil'] = $this->item->get_info_gasoil($country_id,$station_id);
        $data['kerosene'] = $this->item->get_info_kerosene($country_id,$station_id);
        $data['huile'] = $this->item->get_info_huile($country_id,$station_id);
        $data['petrole']  = $this->db->get_where('cd_fluid',array('type'=>5,'country_id'=>$country_id,'station_id'=>$station_id))->row();


        $data['page_title'] = 'Gestion de carte | SOACO e-Station';
        $this->load->view('layout/themes/header',$data);
        $this->load->view('layout/themes/nav',$data);
        $this->load->view('desk/check_done',$data);
        $this->load->view('layout/themes/footer',$data);

    }










    function add_ok()
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('add');
        }

        if ($this->input->server('REQUEST_METHOD')=='POST') {

            // server side validation
            if ( ! $this->is_valid_input()) {
                redirect( site_url('coupons/add' ));
            }

            $upload_data = $this->uploader->upload($_FILES);

            if (!isset($upload_data['error'])) {

                $category_data = array(
                    'name' => htmlentities( $this->input->post('name')),
                    'ordering' => htmlentities($this->input->post('ordering')),
                    'city_id' => $this->get_current_city()->id,
                    'is_published' => 1
                );

                if ($this->category->save($category_data)) {
                    foreach ($upload_data as $upload) {
                        $image = array(
                            'parent_id'=>$category_data['id'],
                            'type' => 'category',
                            'description' => "",
                            'path' => $upload['file_name'],
                            'width'=>$upload['image_width'],
                            'height'=>$upload['image_height']
                        );
                        $this->image->save($image);
                    }

                    $this->session->set_flashdata('success','Category is successfully added.');
                } else {
                    $this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
                }

                redirect(site_url('coupons'));
            } else {
                $this->session->set_flashdata('error', $upload_data['error']);
                redirect(site_url('coupons/add'));
            }
        }

        $content['content'] = $this->load->view('coupons/add',array(),true);
        $this->load_template($content);
    }


    function search()
    {
        $search_term = $this->searchterm_handler(htmlentities($this->input->post('searchterm')));

        $pag = $this->config->item('pagination');

        $pag['base_url'] = site_url('coupons/search');
        $pag['total_rows'] = $this->category->count_all_by($this->get_current_city()->id, array('searchterm'=>$search_term));

        $data['searchterm'] = $search_term;
        $data['categories'] = $this->category->get_all_by(
            $this->get_current_city()->id,
            array('searchterm'=>$search_term),
            $pag['per_page'],
            $this->uri->segment(3)
        );
        $data['pag'] = $pag;

        $content['content'] = $this->load->view('coupons/search',$data,true);

        $this->load_template($content);
    }

    function searchterm_handler($searchterm)
    {
        if ($searchterm) {
            $this->session->set_userdata('searchterm', $searchterm);
            return $searchterm;
        } elseif ($this->session->userdata('searchterm')) {
            $searchterm = $this->session->userdata('searchterm');
            return $searchterm;
        } else {
            $searchterm ="";
            return $searchterm;
        }
    }

    function edit($data_id=0)
    {

        $category_id= url_decode($data_id);

        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }

        if ($this->input->server('REQUEST_METHOD')=='POST') {

//			// server side validation
//			if ( ! $this->is_valid_input( $category_id )) {
//				redirect( site_url( 'categories/edit/' . $category_id ));
//			}

            $category_data = array(
                'name' => htmlentities($this->input->post('name')),
                'ordering' => htmlentities($this->input->post('ordering')),
                'country_id' => htmlentities($this->input->post('country_id')),
                'city_id' => $this->get_current_city()->id
            );

            if($this->category->save($category_data, $category_id)) {
                $this->session->set_flashdata('success','La commune est mise à jour avec succès.');
            } else {
                $this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
            }
            redirect(site_url('categories'));
        }

        $data['category'] = $this->category->get_info($category_id);

        $content['content'] = $this->load->view('coupons/edit',$data,true);

        $this->load_template($content);
    }

    function publish($category_id = 0)
    {
//        if(!$this->session->userdata('is_city_admin')) {
//            $this->check_access('publish');
//        }

        $category_data = array(
            'is_published'=> 1
        );

        if ($this->category->save_cards($category_data, $category_id)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function unpublish($category_id = 0)
    {
//        if(!$this->session->userdata('is_city_admin')) {
//            $this->check_access('publish');
//        }

        $category_data = array(
            'is_published'=> 0
        );

        if ($this->category->save_cards($category_data,$category_id)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function delete($category_id=0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('delete');
        }

        if($this->category->delete($category_id)) {


            $img_filename = $this->image->get_info_parent_type($category_id,'category')->path;

            $this->delete_images( $img_filename );

            $this->image->delete_by_parent($category_id, 'category');

            $this->session->set_flashdata('success','la commune a ete supprime');
        } else {
            $this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
        }
        redirect(site_url('coupons'));
    }

    function delete_items($category_id = 0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('delete');
        }

        if ($this->category->delete($category_id)) {

            $img_filename = $this->image->get_info_parent_type($category_id,'category')->path;

            $this->delete_images( $img_filename );

            $this->image->delete_by_parent($category_id, 'category');

            if($this->delete_sub_categories($category_id)){
                if ($this->delete_items_images($category_id)) {
                    $this->session->set_flashdata('success','The category is successfully deleted.');
                } else {
                    $this->session->set_flashdata('error','Database error occured in items.Please contact your system administrator.');
                }
            } else {
                $this->session->set_flashdata('error','Database error occured in sub categories.Please contact your system administrator.');
            }
        } else {
            $this->session->set_flashdata('error','Database error occured in categories.Please contact your system administrator.');
        }
        redirect(site_url('coupons'));
    }

    function delete_sub_categories($category_id)
    {
        $sub_cats = $this->sub_category->get_all_by_cat($category_id);

        foreach ($sub_cats->result() as $sub_cat) {

            $img_filename = $this->image->get_info_parent_type($sub_cat->id,'sub_category')->path;

            $this->delete_images( $img_filename );

            $this->image->delete_by_parent($sub_cat->id, 'sub_category');
        }

        $this->sub_category->delete_by_cat($category_id);

        return true;
    }

    function delete_items_images($category_id)
    {
        $items = $this->item->get_all_by_cat($category_id);

        foreach ($items->result() as $item) {
            $images = $this->image->get_all_by_type($item->id, 'item');
            foreach ($images->result() as $image) {

                // delete images
                $this->delete_images( $image->path );
            }

            $this->image->delete_by_parent($item->id, 'item');
        }
        $this->item->delete_by_cat($category_id);

        return true;
    }

    function delete_image($category_id, $image_id, $image_name)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }

        if ($this->image->delete($image_id)) {

            $this->delete_images( $image_name );

            $this->session->set_flashdata('success','Category cover photo is successfully deleted.');
        } else {
            $this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
        }
        redirect(site_url('coupons/edit/' . $category_id));
    }

    function exists( $city_id = 0, $category_id = 0 )
    {
        $name = $_REQUEST['name'];
        if (strtolower($this->category->get_info($category_id)->name) == strtolower($name)) {
            echo "true";
        } else if ($this->category->exists(array('name'=>$_REQUEST['name'],'city_id' => $city_id))) {
            echo "false";
        } else {
            echo "true";
        }
    }

    function upload($category_id=0)
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }

        $upload_data = $this->uploader->upload($_FILES);

        if (!isset($upload_data['error'])) {

            $file_name = $this->image->get_info_parent_type($category_id,'category')->path;

            $this->delete_images( $file_name );

            $this->image->delete_by_parent($category_id,'category');

            foreach ($upload_data as $upload) {
                $image = array(
                    'parent_id'=> $category_id,
                    'type' => 'category',
                    'description' => "",
                    'path' => $upload['file_name'],
                    'width'=>$upload['image_width'],
                    'height'=>$upload['image_height']
                );
                $this->image->save($image);
                redirect(site_url('coupons/edit/' . $category_id));
            }

        } else {
            $this->session->set_flashdata('error', $upload_data['error']);
            redirect(site_url('coupons/edit/'. $category_id ));
        }

        $data['category'] = $this->category->get_info($category_id);

        $content['content'] = $this->load->view('coupons/edit',$data,true);
        $this->load_template($content);
    }

    /**
     * Determines if valid input.
     *
     * @param      integer|string  $category_id  The category identifier
     *
     * @return     boolean         True if valid input, False otherwise.
     */
    function is_valid_input( $category_id = 0 )
    {
        $rule = 'required|min_length[3]|callback_is_valid_name['. $category_id  .']';

        $this->form_validation->set_rules('name', 'Name', $rule );

        if ( $this->form_validation->run() == FALSE ) {
            $this->session->set_flashdata('error', validation_errors());
            return false;
        }

        return true;
    }

    /**
     * Check if the name is unique
     *
     * @param      <type>   $name         The name
     * @param      integer  $category_id  The category identifier
     *
     * @return     boolean  True if valid name, False otherwise.
     */
    function is_valid_name( $name, $category_id = 0 )
    {
        $city_id = $this->get_current_city()->id;

        if ( strtolower( $this->category->get_info( $category_id)->name ) == strtolower( $name )) {
            // valid if the name is not changed
            return true;
        } else if ( $this->category->exists( array( 'name' => $_REQUEST['name'], 'city_id' => $city_id ))) {
            // invalid if the name is already existed,
            $this->form_validation->set_message('is_valid_name', 'Nom existe deja dans le systeme');
            return false;
        } else {
            // valid if the name is not existed
            return true;
        }
    }
}
?>