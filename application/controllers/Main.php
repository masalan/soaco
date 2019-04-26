<?php
/**
 * @author Panaceasoft
 */
class Main extends CI_Controller
{
	function __construct($module_name = null)
	{
		parent::__construct();
		
		if ( $module_name != NO_LOGIN_CONTROL ) {
		// if module is not front-end controller, login and permission checking is required

			/* Login Checking */
			if ( ! $this->user->is_logged_in() ) {
			//if user has no permission, redirect to login
				redirect(site_url('login'));
			}
		
			/* Permission Checking */
			$is_frontend_user = $this->user->is_frontend_user();

			if ( ( $is_frontend_user && $module_name != ONLY_LOGIN_CONTROL ) 
			  || ( !$is_frontend_user && $module_name != NO_ACCESS_CONTROL )) {
			// if front end user, permission check is required
			// if back-end user and module name is not 'NO_ACCESS_CONTORL', permission check is required
			
				// get logged in user id
				$user_id = $this->user->get_logged_in_user_info()->user_id;

				if ( !$this->user->has_permission( $module_name, $user_id )) {
				// if user has no permission for the module, show error msg and redirect to login page
					
					$this->session->set_flashdata('error','Vous n\'avez pas la permission pour cette option');
					redirect( site_url( 'login' ));
				}
			}
		}

		//load global data
		$logged_in_user_info = $this->user->get_logged_in_user_info();

		$data = array();

		if ( !empty( $logged_in_user_info )) {

			$user_id = $logged_in_user_info->user_id;
			$role_id = $logged_in_user_info->role_id;

			$data['module_groups'] = $this->module->get_groups_info();		
			$data['allowed_modules'] = $this->module->get_allowed_modules( $user_id );
			$data['allowed_accesses'] = $this->role->get_allowed_accesses( $role_id);
			$data['user_info'] = $logged_in_user_info;
		}
		
		$this->load->vars($data);
	}

	function check_access($action_id = null)
	{
		//If user has no permission,kick off.
		if (!$this->user->is_logged_in()) {
			redirect(site_url('login'));
		}
		
		//If user has no permission  for this module,kick off.
		if (!$this->user->has_access($action_id, $this->user->get_logged_in_user_info()->role_id)) {
			redirect(site_url('dashboard'));
		}
		
		return true;
	}
	
	function load_template($content,$sidebar=true,$edit_mode=false) 
	{
		$template_name = $this->config->item('template');
		$data['content'] = $content;
		$data['sidebar'] = $sidebar;
		$data['edit_mode'] = $edit_mode;
		$this->load->view("templates/". $template_name ."/index", $data);
	}


    function station_template($contenu,$sidebar=true,$edit_mode=false)
    {
        $layout_name = $this->config->item('template');
        $data['contenu'] = $contenu;
        $data['sidebar'] = $sidebar;
        $data['edit_mode'] = $edit_mode;
        $this->load->view("layout/". $layout_name ."/index", $data);
    }

	function get_current_city()
	{
		return $this->city->get_current_city();
	}

	/**
	 * deletes original image and thunmbnail image if exists
	 *
	 * @param      <type>   $img_filename  The image filename
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function delete_images ( $img_filename )
	{
		if ( empty( $img_filename )) {
			return true;
		}
				
		// delete original photo
		$img_path = './uploads/'. $img_filename;
		if ( file_exists( $img_path ) && !empty( $img_filename )) {
			unlink( $img_path );
		}

		// delete thumbnail photo
		$thumb_path = './uploads/thumbnail/'. $img_filename;
		if ( file_exists( $thumb_path )) {
			unlink( $thumb_path );
		}

		return true;
	}
}
?>