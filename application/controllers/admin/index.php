<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends PP_Controller {

	function __construct(){
		
		parent::__construct();
        $this->load->model('User_model');
	}
	
	public function index()
	{

		error_log("admin index");
		if(!$this->session->userdata('logged_in')){
        	redirect('/admin/login');
		}
		
		$layoutData = array();
		$bodyData = "";
		$layoutData['content'] = $this->load->view('admin/index',$bodyData,true);
		$this->load->view('layouts/admin',$layoutData);
	}


// 	public function testemail(){
// 		$this->load->model('Mail_model');
// 		echo $this->Mail_model->pearMail('nwstesting11@hotmail.com','support@petpassages.com',"Thank you for your payment.","Thank you for your $156.60 payment. Please consider this email a receipt for
// your payment.",$bcc=false,$cc=false,$html=false);
// 		echo "test";
// 	}
	
	public function forgot()
	{
		if($_POST) {
			//authenticate
			if($this->input->post('username') || $this->input->post('email')) {
				if($this->User_model->forgot($this->input->post('username'),$this->input->post('email'))) {
					$this->messages->add($this->lang->line('forgot_success'), 'success');
				}else{
					$this->messages->add($this->lang->line('forgot_not_found'), 'error');
				}
			}else{
				$this->messages->add($this->lang->line('forgot_none_entered'), 'error');
			}
		}
		
		$bodyData = array();
		$layoutData['content'] = $this->load->view('admin/forgot',$bodyData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function reset() {
		$bodyData = array();
		$bodyData['form'] = true;
		//echo $this->uri->segment(3);
		//$hash = str_replace('?','',$this->uri->segment(3));
		if($this->User_model->checkHash($this->uri->segment(3))) {
			if($this->input->post('password')) {
				//authenticate
				if($this->User_model->reset($this->input->post('password'),$this->input->post('hash'))) {
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

		$layoutData['content'] = $this->load->view('admin/reset',$bodyData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function login()
	{
		$layoutData = array();
		$bodyData = "";
		//authenticate user
		if($this->input->post('username')) {
			$this->session->set_userdata('language', 'english');
			
			//authenticate
			$userObject = $this->User_model->authenticate($this->input->post('username'),$this->input->post('password'));
			error_log(print_r($userObject,1));
			if($userObject) {
				redirect('/admin'); 
			}
			
		}
		if($this->uri->segment(3)){
			$this->messages->add($this->lang->line('logout_success'), 'success');
		}
		
		$layoutData['content'] = $this->load->view('admin/login',$bodyData,true);
		$this->load->view('layouts/admin',$layoutData);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/admin/login/1');
	}
	
	public function auth()
	{
		$hash = $this->uri->segment(3);
		$email = urldecode($this->uri->segment(4));
		$timestamp = $this->uri->segment(5);
		
		if($this->User_model->hashAuthentication($hash,$email,$timestamp))
			redirect('/admin'); 
		else{
			redirect('/admin/noaccess/auth'); 
		$layoutData = array();
		$layoutData['content'] = $this->load->view('admin/noaccess/index',$layoutData,true);
		$this->load->view('layouts/admin',$layoutData);
		}
	}
	
	public function hash()
	{
//		//single sign-on link generation
//		//simple replace the below email address with the users email address.
//		$email = "ivan@ivansugerman.com"; 
//		
//		$timestamp = time();
//		$secretKey = "cd39a5a54c28d426bb63d0b6c4fafa8d";
//		$generatedHash = md5($secretKey.$email.$timestamp);
//		$email = urlencode($email);
//		
//		echo "http://petpassages.com/admin/auth/$generatedHash/$email/$timestamp";
			
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */