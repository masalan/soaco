<?php
require_once('Main.php');

class Favourites extends Main
{
	function __construct()
	{
		parent::__construct('favourites');
		$this->load->library('common');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		
		$pag['base_url'] = site_url('favourites/index');
		$pag['total_rows'] = $this->favourite->count_all($this->get_current_city()->id);
		$data['favourites'] = $this->favourite->get_all($this->get_current_city()->id, $pag['per_page'], $this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('favourites/list', $data, true);		
		
		$this->load_template($content);
	}
}
?>