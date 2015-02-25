<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noaccess extends PP_Controller {

	function __construct(){
		parent::__construct();
		
		if(!$this->session->userdata('owner_logged_in') && $this->uri->segment(2) != "login"){
        	redirect('owner/login');
		}
		
	}
	
	public function index()
	{
		$this->messages->add($this->lang->line('no_access'), 'error');
		$layoutData = array();
		$layoutData['content'] = $this->load->view('admin/noaccess/index',$layoutData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */