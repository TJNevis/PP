<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indexn extends PP_Controller {

	function __construct(){
		
		parent::__construct();
        	
		if( isset($_GET['embed']) && $_GET['embed']=="true"){
            $this->session->set_userdata('embed',true);
        }

		if(empty($_SERVER['HTTPS']))
			redirect("https://".$this->session->userdata('sub_domain')."/owner/");
        
		$this->load->model('Owner_model');
	}
	
	public function index()
	{
		if(!$this->session->userdata('owner_logged_in')){
        	redirect('/owner/login');
		}
		
		$layoutData = array();
		$bodyData = array();
		$bodyData['pet_information_active'] = true;
		
		$layoutData['content'] = $this->load->view('owner/index',$bodyData,true);
		$layoutData['tabs'] = true;
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function understanding() {
		$layoutData = array();
		$bodyData = array();
		$layoutData['content'] = $this->load->view('owner/understanding',$bodyData,true);
		$layoutData['tabs'] = true;

		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}

	public function children() {
		$layoutData = array();
		$bodyData = array();
		$layoutData['content'] = $this->load->view('owner/children',$bodyData,true);
		$layoutData['tabs'] = true;
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function forgot()
	{
		if($_POST) {
			//authenticate
			if($this->input->post('username') || $this->input->post('email')) {
				if($this->Owner_model->forgot($this->input->post('username'),$this->input->post('email'))) {
					$this->messages->add($this->lang->line('forgot_success'), 'success');
				}else{
					$this->messages->add($this->lang->line('forgot_not_found'), 'error');
				}
			}else{
				$this->messages->add($this->lang->line('forgot_none_entered'), 'error');
			}
		}
		
		$bodyData = array();
		$layoutData['content'] = $this->load->view('owner/forgot',$bodyData,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function reset() {
		$bodyData = array();
		$bodyData['form'] = true;
		
		if($this->Owner_model->checkHash($this->uri->segment(3))) {
			if($this->input->post('password')) {
				//authenticate
				if($this->Owner_model->reset($this->input->post('password'),$this->input->post('hash'))) {
					$this->messages->add($this->lang->line('reset_success'), 'success');
					$bodyData['form'] = false;
				}else{
					$this->messages->add($this->lang->line('reset_error'), 'error');
				}
			}
		}else{
			$this->messages->add($this->lang->line('reset_hash_expired'), 'error');
			$bodyData['form'] = false;
		}

		$layoutData['content'] = $this->load->view('owner/reset',$bodyData,true);
		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function login()
	{
		$layoutData = array();
		$bodyData = array();
		
		
		//authenticate user
		if($this->input->post('username')) {
			$this->session->set_userdata('language', 'english');
			
			//authenticate
			$user = $this->Owner_model->authenticate($this->input->post('username'),$this->input->post('password'));
			if($user)
				redirect('/owner/'); 
			else
				$this->messages->add($this->lang->line('login_user_incorrect'),'error');
				redirect('/owner/login');
		}
		
		//if the person is loggin out the add the logged out message
		if($this->uri->segment(3))
			$this->messages->add($this->lang->line('logout_success'), 'success');
		
		//turn off tabs
		$layoutData['tabs'] = false;
		$layoutData['content'] = $this->load->view('owner/login',$bodyData,true);

		if($this->session->userdata('embed')==true)
                        $this->load->view('layouts/owner_embed',$layoutData);
                else
                        $this->load->view('layouts/owner',$layoutData);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		if( isset($_GET['embed']) && $_GET['embed']=="true"){
            $this->session->set_userdata('embed',true);
            redirect('/owner/login/1?embed=true');
        }else{
        	redirect('/owner/login/1');
        }
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
