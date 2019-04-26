<?php
require_once('Main.php');
class Abouts extends Main
{
	function __construct()
	{
		parent::__construct('abouts');
		$this->load->library('uploader');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
		
		$pag['base_url'] = site_url('about/index');
		$data['about'] = $this->about->get_info(1);
		$content['content'] = $this->load->view('about/add',$data,true);		
		$this->load_template($content, false);
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

	 		if ( $this->input->post( 'generate-sitemap' )) {
	 			if ( $this->generate_sitemap() ) {
	 				$this->session->set_flashdata('success','Sitemap has been generated');
	 			} else {
	 				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
	 			}
	 			redirect(site_url('abouts'));
	 		}
	 		
	 		if ($this->input->server('REQUEST_METHOD')=='POST') {

	 			$this->form_validation->set_rules('title', 'Title', 'required|min_length[5]');

	 			if ( $this->form_validation->run() == FALSE ) {
	 				$this->session->set_flashdata('error', validation_errors());
	 				redirect(site_url('abouts'));
	 			}

	 			$feed_data = $this->input->post();
	 
	 			$temp = array();
	 			foreach ( $feed_data as $key=>$value ) {
	 				$temp[$key] = $value;
	 			}
	 			
	 			$about_data = $temp;
	 			$about_data['id'] = 1;
	 			if ($this->about->save($about_data,1)) {			
	 				$this->session->set_flashdata('success','About Information is successfully added.');
	 			} else {
	 				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
	 			}
	 			
	 			if ($action == "gallery") {
	 				redirect(site_url('abouts/gallery/'.$about_data['id']));
	 			} else {
	 				redirect(site_url('abouts'));
	 			}
	 		}
	 		$data['about'] = $this->about->get_info(1);
	 		$content['content'] = $this->load->view('abouts/add',array(),true);
	 		$this->load_template($content);	 
	}
		
		
	function edit($feed_id=0)
	{
		
	}
	
	function gallery($id)
	{
		//session_start();
		$_SESSION['parent_id'] = $id;
		$_SESSION['type'] = 'about';
    	$content['content'] = $this->load->view('about/gallery', array('id' => $id), true);
    	
    	$this->load_template($content);
	}
	
	function upload($feed_id=0)
	{
		if(!$this->session->userdata('is_city_admin')) {
		    $this->check_access('edit');
		}
		
		$upload_data = $this->uploader->upload($_FILES);
		
		if (!isset($upload_data['error'])) {
			foreach ($upload_data as $upload) {
				$image = array(
								'item_id'=> $feed_id,
								'type' => 'about',
								'path' => $upload['file_name'],
								'width'=>$upload['image_width'],
								'height'=>$upload['image_height']
							);
				$this->image->save($image);
			}
		} else {
			$data['error'] = $upload_data['error'];
		}
		
		$data['about'] = $this->about->get_info($feed_id);
		
		$content['content'] = $this->load->view('abouts/add',$data,true);		
		
		$this->load_template($content);
	}
	
	
	function delete_image($feed_id,$image_id,$image_name)
	{
		if(!$this->session->userdata('is_city_admin')) {
		    $this->check_access('edit');
		}
		
		if ($this->image->delete($image_id)) {
			unlink('./uploads/'.$image_name);
			$this->session->set_flashdata('success','Image is successfully deleted.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('feeds/edit/'.$feed_id));
	}

	function generate_sitemap()
	{
		// load xml helper
		$this->load->helper('file');

		// base urls
		$site_url = site_url();
		$city_url = site_url( 'CityInfo/index/');
		$item_url = site_url( 'ItemInfo/index/');

		// home page
		$sitemap[] = array( 'loc' => $site_url );

		// about us page
		$sitemap[] = array( 'loc' => site_url( 'about_us' ));

		// contact us page
		$sitemap[] = array( 'loc' => site_url( 'contact_us'));

		// cities
		$cities = $this->city->get_all_by( array( 'is_approved' => 1 ))->result();
		if ( !empty( $cities )) {
			foreach ( $cities as $city ) {
				$sitemap[] = array( 'loc' => $city_url . $city->id, 'lastmod' => $city->added );
			}
		}

		// items
		$items = $this->item->get_all()->result();
		if ( !empty( $items )) {
			foreach ( $items as $item ) {
				$sitemap[] = array( 'loc' => $item_url . $item->id, 'lastmod' => $item->added );
			}
		}

		// generate xml
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		if ( !empty( $sitemap )) {
			foreach ( $sitemap as $site ) {
				$xml .= '<sitemap>';
				if ( isset( $site['loc'] )) $xml .= '<loc>'. $site['loc'] .'</loc>';
				if ( isset( $site['lastmod'] )) $xml .= '<lastmod>'. $site['lastmod'] .'</lastmod>';
				$xml .= '</sitemap>';
			}
		}
		$xml .= '</sitemapindex>';

		return write_file( 'sitemap.xml', $xml );
	}
}
?>