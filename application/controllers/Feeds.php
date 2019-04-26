<?php
require_once('Main.php');
class Feeds extends Main
{
	function __construct()
	{
		parent::__construct('feeds');
		$this->load->library('uploader');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
		
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('feeds/index');
		$pag['total_rows'] = $this->feed->count_all($this->get_current_city()->id);
		$data['feeds'] = $this->feed->get_all($this->get_current_city()->id, $pag['per_page'], $this->uri->segment(3));
		$data['pag'] = $pag;

//        var_dump($data);
//        exit();
		
		$content['content'] = $this->load->view('feeds/list',$data,true);
		$this->load_template($content);
	}


    /***
     *  OK Update
     */
    function add()
    {
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('add');
        }

        if ($this->input->server('REQUEST_METHOD')=='POST') {
            // server side validation
            if ( ! $this->is_valid_input()) {
                redirect( site_url( 'feeds/add' ));
            }
            if(htmlentities($this->input->post('role_id')) == 4){
                $is_city_admin = 1;
            } else {
                $is_city_admin = 0;
            }

            $station = $this->db->get_where('cd_items',array('id'=>htmlentities($this->input->post('station_id'))));
            $company_id = $station->row()->company_id;
            $country_id = $station->row()->country_id;

            $user_data = array(
                'fullname'=>htmlentities($this->input->post('title')),
                'phone'=>htmlentities($this->input->post('phone')),
                'user_name' => htmlentities($this->input->post('user_name')),
                'user_email' => htmlentities($this->input->post('user_email')),
                'user_pass'=> md5($this->input->post('user_password')),
                'role_id'=>htmlentities($this->input->post('role_id')),
                'arrondissement_id'=>htmlentities($this->input->post('arrondissement_id')),
                'father'=>htmlentities($this->input->post('father')),
                'mother'=>htmlentities($this->input->post('mother')),
                'question'=>htmlentities($this->input->post('question')),
                'answer'=>htmlentities($this->input->post('answer')),
                'country_id'=>htmlentities($this->input->post('country_id')),
                'company_id'=>$company_id,
                'country_id'=>$country_id,
                'added' => date("Y-m-d H:i:s"),
                'is_published'=>htmlentities($this->input->post('is_published')),
                'station_id'=>htmlentities($this->input->post('station_id')),
                'city_id'=>htmlentities($this->city->get_current_city()->id),
                'is_city_admin' => $is_city_admin,
                'is_gerant' => 1
            );


            $permissions = $this->input->post('permissions')!=false? $this->input->post('permissions'): array();
            if ($this->user->save($user_data,$permissions)) {
                if ($is_city_admin ) {
                    $city_id = $this->input->post('city_id' );
                    $city_data = array( 'admin_id' => $user_data['user_id']);

                        if ($this->feed->save($city_data,$city_id)) {
                            $this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
                    }
                }

                $activities = array(
                    'user_id'        => $this->session->userdata('user_id'),
                    'id_item'        => $user_data['user_id'] ,
                    'nom_item'       => htmlentities($this->input->post('title')),
                    'depart_id'      => htmlentities($this->city->get_current_city()->id),
                    'com_id'         => 'xx',
                    'arr_id'         => htmlentities($this->input->post('arrondissement_id')),
                    'name'           => 'Ajout d`un Gerant',
                    'description'    => 'Ajout d`un Gerant',
                    'type'           => '1',
                    'added'          => date("Y-m-d H:i:s"),
                    'role_id'        => htmlentities($this->input->post('role_id'))
                );
                $this->user->log_action($activities);


                $this->session->set_flashdata('success','Le Gerant de la station est ajouté avec succès.');
            } else {
                $this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
            }
            redirect(site_url('gerants'));
        }
        $pag['city'] = $this->get_current_city()->id;
        $content['content'] = $this->load->view('feeds/add',$pag,true);
        $this->load_template($content);
    }


    /**
     *  OK
     */
	function search()
	{
		$search_term = $this->searchterm_handler(array(
			"searchterm"=>htmlentities($this->input->post('searchterm'))
		));
		$data = $search_term;
		
		$pag = $this->config->item('pagination');
		
		$pag['base_url'] = site_url('feeds/search');
		$pag['total_rows'] = $this->feed->count_all_by($this->get_current_city()->id, $search_term);
		
		$data['feeds'] = $this->feed->get_all_by($this->get_current_city()->id, $search_term,$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		
		$content['content'] = $this->load->view('feeds/search',$data,true);		
		
		$this->load_template($content);
	}
	
	function searchterm_handler($searchterms = array())
	{
		$data = array();
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {
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


    /**
     * @param $userid
     * Update
     */
    function edit($userid)
    {
        $user_id = url_decode($userid);
        if(!$this->session->userdata('is_city_admin')) {
            $this->check_access('edit');
        }
        if ($this->input->server('REQUEST_METHOD')=='POST') {
            // server side validation
            if ( ! $this->is_valid_input( $user_id )) {
                redirect( site_url( 'feeds/edit/'. $user_id ));
            }
            if ($this->user->get_logged_in_user_info()->user_id != $user_id &&
                $this->user->get_info($user_id)->is_owner == 1) {
                $this->session->set_flashdata('error','You can\'t edit site owner.');
            } else {
                if(htmlentities($this->input->post('role_id')) == 4){
                    $is_city_admin = 1;
                } else {
                    $is_city_admin = 0;
                }
                $station = $this->db->get_where('cd_items',array('id'=>htmlentities($this->input->post('station_id'))));
                $company_id = $station->row()->company_id;
                $country_id = $station->row()->country_id;


                $user_data = array(
                    'fullname'=>htmlentities($this->input->post('title')),
                    'phone'=>htmlentities($this->input->post('phone')),
                    'user_name' => htmlentities($this->input->post('user_name')),
                    'user_email' => htmlentities($this->input->post('user_email')),
//                    'user_pass'=> md5($this->input->post('user_password')),
                    'role_id'=>htmlentities($this->input->post('role_id')),
                    'arrondissement_id'=>htmlentities($this->input->post('arrondissement_id')),
                    'company_id'=>$company_id,
                    'country_id'=>$country_id,
                    'father'=>htmlentities($this->input->post('father')),
                    'mother'=>htmlentities($this->input->post('mother')),
                    'question'=>htmlentities($this->input->post('question')),
                    'answer'=>htmlentities($this->input->post('answer')),
                    'updated' => date("Y-m-d H:i:s"),
                    'station_id'=>htmlentities($this->input->post('station_id')),

                    'is_published'=>htmlentities($this->input->post('is_published')),
                    'city_id'=>htmlentities($this->city->get_current_city()->id),
                    'is_city_admin' => $is_city_admin,
                    'is_gerant' => 1
                );

                if ( $is_city_admin ) {

                    // remove admin id from existing city
                    $old_cities = $this->city->get_all_by( array( 'admin_id' => $user_id ))->result();

                    if ( !empty( $old_cities )) {
                        foreach ( $old_cities as $old_city ) {
                            $old_city_id = $old_city->id;
                            $data = array( 'admin_id' => 0 );
                            $this->city->save( $data, $old_city_id );
                        }
                    }

                    // add admin id to new city
                    $city_id = $this->input->post( 'city_id' );
                    $city_data = array( 'admin_id' => $user_id );

                    $this->city->save( $city_data, $city_id );
                }

                //If new user password exists,change password
                if ($this->input->post('user_password')!='') {
                    $user_data['user_pass'] = md5($this->input->post('user_password'));
                }

               if ($this->feed->save($user_data, $user_id)) {

                   $activities = array(
                       'user_id'        => $this->session->userdata('user_id'),
                       'id_item'        => $user_id,
                       'nom_item'       => htmlentities($this->input->post('title')),
                       'depart_id'      => htmlentities($this->city->get_current_city()->id),
                       'com_id'         => '',
                       'arr_id'         => htmlentities($this->input->post('arrondissement_id')),
                       'name'           => 'Modification d`un Gerant',
                       'description'    => 'Modification d`un Gerant',
                       'type'           => '1',
//                       'company_id'=>$company_id,
                       'country_id'=>$country_id,
                       'added'          => date("Y-m-d H:i:s"),
                       'role_id'        => htmlentities($this->input->post('role_id'))
                   );
                   $this->user->log_action($activities);

                   $this->session->set_flashdata('success','Le Gerant de la station a ete mise a jour avec succès.');
                } else {
                    $this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
                }
            }
            redirect(site_url('gerants'));
        }

        $data['user'] = $this->user->get_info($user_id);

        $content['content'] = $this->load->view('feeds/edit',$data,true);

        $this->load_template($content);
    }


	
	function gallery($id)
	{
		// session_start();
		$_SESSION['parent_id'] = $id;
		$_SESSION['type'] = 'feed';
    	$content['content'] = $this->load->view('feeds/gallery', array('id' => $id), true);
    	
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
								'type' => 'feed',
								'path' => $upload['file_name'],
								'width'=>$upload['image_width'],
								'height'=>$upload['image_height']
							);
				$this->image->save($image);
			}
		} else {
			$data['error'] = $upload_data['error'];
		}
		
		$data['feed'] = $this->feed->get_info($feed_id);
		
		$content['content'] = $this->load->view('feeds/edit',$data,true);		
		
		$this->load_template($content);
	}
	
	function publish($id = 0)
	{
		if(!$this->session->userdata('is_city_admin')) {
			$this->check_access('publish');
		}
		
		$feed_data = array(
			'status'=> 1
		);
			
		if ($this->feed->save($feed_data,$id)) {
            $activities = array(
                'user_id'        => $this->session->userdata('user_id'),
                'id_item'        => $id,
                'nom_item'       => '',
                'depart_id'      => '',
                'com_id'         => '',
                'arr_id'         => '',
                'name'           => 'Rendre active un Gerant',
                'description'    => 'Rendre active Gerant',
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
	
	function unpublish($id = 0)
	{
		if(!$this->session->userdata('is_city_admin')) {
			$this->check_access('publish');
		}
		
		$feed_data = array(
			'status'=> 0
		);
			
		if ($this->feed->save($feed_data,$id)) {

            $activities = array(
                'user_id'        => $this->session->userdata('user_id'),
                'id_item'        => $id,
                'nom_item'       => '',
                'depart_id'      => '',
                'com_id'         => '',
                'arr_id'         => '',
                'name'           => 'Desactiver un Gerant',
                'description'    => 'Desactiver un Gerant',
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

	function delete($feed_id=0)
	{
		if(!$this->session->userdata('is_city_admin')) {
		     $this->check_access('delete');
		}
		
		$images = $this->image->get_all_by_type($feed_id, 'feed');
		foreach ($images->result() as $image) {
			$this->image->delete($image->id);
			unlink('./uploads/'.$image->path);
		}
		
		if ($this->feed->delete($feed_id)) {

            $activities = array(
                'user_id'        => $this->session->userdata('user_id'),
                'id_item'        => $feed_id,
                'nom_item'       => '',
                'depart_id'      => '',
                'com_id'         => '',
                'arr_id'         => '',
                'name'           => 'Suppression d`un Gerant',
                'description'    => 'Suppression d`un Gerant',
                'type'           => '1',
                'added'          => date("Y-m-d H:i:s"),
                'role_id'        => ''
            );
            $this->user->log_action($activities);


			$this->session->set_flashdata('success','Le Gerant a éte supprimé avec succès.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('feeds'));
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

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input()
	{
		$rule = 'required|min_length[3]';

		$this->form_validation->set_rules('title', 'Title', $rule );
		$this->form_validation->set_rules('description', 'Description', $rule );

		if ( $this->form_validation->run() == FALSE ) {
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}

		return true;
	}
}
?>