<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    private static $instance;
    public  $sess_id = null;
    public $url_path = 'http://soaco:8888/';
    public  $user_basic;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('PRC');
        $this->sess_id = $this->input->get('sess_id') ? $this->input->get('sess_id') : $this->input->post('sess_id');
        $this->load->driver('cache');
        if($this->sess_id){
            $this->user_basic = $this->cache->memcached->get($this->sess_id);
        }
    }

    public function need_login(){
       if(empty($this->sess_id) ||  !($this->user_basic = $this->cache->memcached->get($this->sess_id))){
                $this->_ajax_return(201,'Connectez-vous');
        }
    }
    /**
     *  json format data is returned
     *  @param int 	  $code
     *  @param string $message
     *  @param array  $data
     *  @param string $type AJAX
     *  @return void
     */
    public function _ajax_return($code, $message, $result = array(), $type = 'JSON')
    {
        $data = array(
            'code' 	  => $code ?: 0,
            'message' => $message,
            'data'    => $result
        );
        switch (strtoupper($type)){
            case 'JSON' :
                // Returns JSON data format that contains state information to the client
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data));
            case 'XML'  :
                // Back xml format data
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // Returns JSON data format that contains state information to the client
                header('Content-Type:application/json; charset=utf-8');
                $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler.'('.json_encode($data).');');
            case 'EVAL' :
                // Back executable js script
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
        }
    }

    /**
     *  Upload Picture
     * return Back picture
     * Upload multi picture
     *
     */
    public function file_upload($name){
        $allow_file_type = array('jpg','jpeg','png','gif','bmp','pdf','mp4','doc','xls');
        if(is_array($_FILES)){
            foreach($_FILES as $v){
                if(!in_array($this->get_extension($v['name']), $allow_file_type)){
                    $this->_ajax_return(500, 'Image upload failure');
                }
            }
        }
        $config['upload_path']      = './uploads/';
        $config['allowed_types']    = '*';
        $config['max_size']     = 10000000;
        $config['encrypt_name']       = TRUE;
        $config['mod_mime_fix']       = TRUE;
        $config['detect_mime']       = TRUE;
        $config['overwrite']       = TRUE;
        $config['file_ext_tolower']       = TRUE;
        $this->load->library('upload', $config);
        $file_array = array();
        if(is_array($_FILES)){
            foreach($_FILES as $key=>$value){
                if(strstr($key, $name)){
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($key)){
                        $error = array('error' => $this->upload->display_errors());
                        $this->_ajax_return(500, 'Image upload failure');
                    }else{
                        $file_array[] =  $this->url_path.'uploads/'.$this->upload->data('file_name');
                    }
                }
            }
            return $file_array;
        }
    }

    //User upload file
    public function user_upload($name){
        $allow_file_type = array('jpg','jpeg','png','gif','bmp','pdf','mp4','doc','xls');
        if(is_array($_FILES)){
            foreach($_FILES as $v){
                if(!in_array($this->get_extension($v['name']), $allow_file_type)){
                    $this->_ajax_return(500, 'Image upload failure');
                }
            }
        }
        $config['upload_path']      = './uploads/';
        $config['allowed_types']    = '*';
        $config['max_size']     = 10000000;
        $config['encrypt_name']       = TRUE;
        $config['mod_mime_fix']       = TRUE;
        $config['detect_mime']       = TRUE;
        $config['overwrite']       = TRUE;
        $config['file_ext_tolower']       = TRUE;
        $this->load->library('upload', $config);
        $file_array = array();
        if(is_array($_FILES)){
            foreach($_FILES as $key=>$value){
                if(strstr($key, $name)){
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($key)){
                        $error = array('error' => $this->upload->display_errors());
                        $this->_ajax_return(500, 'Image upload failure');
                    }else{
                        $file_array[] =  $this->url_path.'user_uploads/'.$this->upload->data('file_name');
                    }
                }
            }
            return $file_array;
        }
    }


    //Upload Background

    public function bg_upload($name){
        $allow_file_type = array('jpg','jpeg','png','gif','bmp','pdf','mp4','doc','xls');
        if(is_array($_FILES)){
            foreach($_FILES as $v){
                if(!in_array($this->get_extension($v['name']), $allow_file_type)){
                    $this->_ajax_return(500, 'Image upload failure');
                }
            }
        }
        $config['upload_path']      = './bg/';
        $config['allowed_types']    = '*';
        $config['max_size']     = 10000000;
        $config['encrypt_name']       = TRUE;
        $config['mod_mime_fix']       = TRUE;
        $config['detect_mime']       = TRUE;
        $config['overwrite']       = TRUE;
        $config['file_ext_tolower']       = TRUE;
        $this->load->library('upload', $config);
        $file_array = array();
        if(is_array($_FILES)){
            foreach($_FILES as $key=>$value){
                if(strstr($key, $name)){
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($key)){
                        $error = array('error' => $this->upload->display_errors());
                        $this->_ajax_return(500, 'Image upload failure');
                    }else{
                        $file_array[] =  $this->url_path.'bg/'.$this->upload->data('file_name');
                    }
                }
            }
            return $file_array;
        }
    }


    public function form_file_upload($name){
        $allow_file_type = array('jpg','jpeg','png','gif','bmp','pdf','mp4','doc','xls');
        if(is_array($_FILES)){
            foreach($_FILES as $v){
                if(!in_array($this->get_extension($v['name']), $allow_file_type)){
                    $this->_ajax_return(500, 'Image upload failure');
                }
            }
        }
        $config['upload_path']      = './forms/';
        $config['allowed_types']    = '*';
        $config['max_size']     = 10000000;
        $config['encrypt_name']       = TRUE;
        $config['mod_mime_fix']       = TRUE;
        $config['detect_mime']       = TRUE;
        $config['overwrite']       = TRUE;
        $config['file_ext_tolower']       = TRUE;
        $this->load->library('upload', $config);
        $file_array = array();
        if(is_array($_FILES)){
            foreach($_FILES as $key=>$value){
                if(strstr($key, $name)){
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload($key)){
                        $error = array('error' => $this->upload->display_errors());
                        $this->_ajax_return(500, 'Image upload failure');
                    }else{
                        $file_array[] =  $this->url_path.'forms/'.$this->upload->data('file_name');
                    }
                }
            }
            return $file_array;
        }
    }









    private function  get_extension($file)
    {
        return substr(strrchr($file, '.'), 1);
    }





}