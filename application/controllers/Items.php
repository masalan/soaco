<?php
require_once('Main.php');

class Items extends Main
{
	function __construct()
	{
		parent::__construct('items');
		$this->load->library('uploader');
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
		$pag['total_rows'] = $this->item->count_all($this->get_current_city()->id);
		$data['items'] = $this->item->get_all_items($this->get_current_city()->id, $pag['per_page'], $this->uri->segment(3));
		$data['pag'] = $pag;

		$content['content'] = $this->load->view('items/list', $data, true);

		$this->load_template($content);
	}
	
	function add()
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
			if ( ! $this->is_valid_input()) {
				redirect( site_url( 'items/add' ));
			}

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
			
			if ($this->item->save($item_data)) {			
				$this->session->set_flashdata('success','La Station est ajoutée avec succès.');
			} else {
				$this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
			}
			
			if ($action == "gallery") {
				redirect(site_url('items/gallery/'.$item_data['id']));
			} else {
				redirect(site_url('items'));
			}
		}
		
		$cat_count = $this->category->count_all($this->get_current_city()->id);
		$sub_cat_count = $this->sub_category->count_all($this->get_current_city()->id);
		
		if($cat_count <= 0 && $sub_cat_count <= 0) {
			$this->session->set_flashdata('error','Oops! Veuillez créer d`abord la Commune et l`Arrondissement avant de créer les stations.');
			redirect(site_url('items'));	
		} else {
			if($cat_count <= 0) {
				$this->session->set_flashdata('error','Oops! Veuillez créer la Commune d`abord avant de créer les station.');
				redirect(site_url('items'));
			} else if ($sub_cat_count <= 0) {
				$this->session->set_flashdata('error','Oops! Veuillez créer les arrondissement d`abord avant de créer les station.');
				redirect(site_url('items'));
			}
		}
		
		$content['content'] = $this->load->view('items/add',array(),true);
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
		
		$pag['base_url'] = site_url('items/search');
		$pag['total_rows'] = $this->item->count_all_by($this->get_current_city()->id, $search_term);
		
		$data['items'] = $this->item->get_all_by($this->get_current_city()->id, $search_term, $pag['per_page'], $this->uri->segment(3));
		$data['pag'] = $pag;
		
		$content['content'] = $this->load->view('items/search',$data,true);		
		
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
	
	function edit($data_id=0)
	{
        $item_id = url_decode($data_id);

		if(!$this->session->userdata('is_city_admin')) {
		    $this->check_access('edit');
		}
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {

			// server side validation
			if ( ! $this->is_valid_input( $item_id )) {

				redirect( site_url( 'modifier/station/'. $data_id ));
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
			redirect(site_url('items'));
		}
		
		$data['item'] = $this->item->get_info($item_id);
		
		$content['content'] = $this->load->view('items/edit',$data,true);		
		
		$this->load_template($content);
	}
	
	function gallery($id)
	{
		session_start();
		$_SESSION['parent_id'] = $id;
		$_SESSION['type'] = 'item';
    	$content['content'] = $this->load->view('items/gallery', array('id' => $id), true);

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
		
		$content['content'] = $this->load->view('items/edit',$data,true);		
		
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















    function delete($item_id=0)
	{
		if(!$this->session->userdata('is_city_admin')) {
		     $this->check_access('delete');
		}
		
		$images = $this->image->get_all_by_type($item_id, 'item');
		foreach ($images->result() as $image) {
			$this->image->delete($image->id);
			$this->delete_images( $image->path );
		}
		
		if ($this->item->delete($item_id)) {
			$this->session->set_flashdata('success','La station a été supprimée avec succès.');
		} else {
			$this->session->set_flashdata('error','Une erreur de base de données s\'est produite. Veuillez contacter votre administrateur système.');
		}
		redirect(site_url('items'));
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
		redirect(site_url('items/edit/'.$item_id));
	}
	
	function get_sub_cats($cat_id) 
	{
		$sub_categories = $this->sub_category->get_all_by_cat_id($cat_id);
		echo json_encode($sub_categories->result());
	}

    function get_station($cat_id)
    {
       // $sub_categories = $this->sub_category->get_all_by_cat_id($cat_id);
        $query = $this->db->get_where('cd_items' , array('sub_cat_id'=>$cat_id,'is_published' =>1));
        echo json_encode($query->result());
    }


    /**
     * Ok liste Station
     * @param $id
     */
    function get_station_list($id)
    {
        $query = $this->db->get_where('cd_items', array('sub_cat_id'=>$id,'is_published' =>1))->result_array();
        foreach ($query as $row) {
            echo '<option value="' . $row['id'].'"> '.$row['name'].'</option>';
        }
    }



    /**
     * Modifier le Gerant Station
     * @param $cat_id
     */
    function get_station_modif($cat_id)
    {
        $query = $this->db->get_where('cd_items' , array('sub_cat_id'=>$cat_id,'is_published' =>1));
        echo json_encode($query->result());
    }
    /***
     * Quartier
     * @param $data_id
     */
    function get_quartier_station($data_id)
    {
        $query = $this->db->get_where('quartier' , array('sub_cat_id'=>$data_id,'is_published' =>1));
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

		//$this->form_validation->set_rules('name', 'Name', $rule );
      //  $this->form_validation->set_rules('name', 'Name', $rule );
        $this->form_validation->set_rules('phone', 'phone', $rule );

      // $this->form_validation->set_rules('unit_price', 'Price', 'is_natural_no_zero' );

		if ( $this->form_validation->run() == FALSE ) {
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}

		return true;
	}





    function exists_phone($item_id = 0)
    {
        $phone = trim($_REQUEST['phone']);
        $ID = $_REQUEST['user_id'];

        if (trim(strtolower($this->item->get_info_exit($item_id)->phone)) == strtolower($phone)) {
            echo "true";
        } else if($this->item->check_exists(array(
            'phone'=> $phone,
            'user_id' => $ID
        )))
        {
            echo "false";
        } else {

            echo "true";
        }
    }


    function exists_pseudo( $item_id = 0)
    {
        $name = trim($_REQUEST['name']);
        $ID = $_REQUEST['sub_cat_id'];

        if (trim(strtolower($this->item->get_info_exit($item_id)->name)) == strtolower($name)) {
            echo "true";
        } else if($this->item->check_exists(array(
            'name'=> $name,
            'sub_cat_id' => $ID
        )))
        {
            echo "false";
        } else {

            echo "true";
        }
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