<?php
class Mail_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Global_model');
    }
    
	function adminMail($subject, $message, $from="noreply@petpassages.com",$htmlEmail=false,$test=false) {
		
		if($htmlEmail) {
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
		}
		
		//get super admins
//		$adminUsers = $this->Global_model->get('users',array('type'=>'pp_admin'));
//		
//		$adminEmails = array();
//		foreach($adminUsers as $au) {
//			$adminEmails[]=$au['email_address'];
//		}
		//$to = implode(",",$adminEmails);
		if($test)
			$to = "ivan@ivansugerman.com";
		else
			$to = "mikeharris@harrisfuneralhome.com";

		if($this->session->userdata('contact_email')){
			$to .= ",".$this->session->userdata('contact_email');
		}

		$this->email->from($from, 'Pet Passages');
		$this->email->to($to);
		
		$this->email->bcc('www@nextwaveservices.com'); 
		$this->email->subject($subject);
		$this->email->message($message);	
		
		return $this->email->send();
	}
	
	function sendEmail($to,$from,$subject,$message,$bcc=false,$cc=false) {

		return $this->pearMail($to,$from,$subject,$message,$bcc,$cc);
	}
	
	function sendHTMLEmail($to,$from,$subject,$message) {
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$this->email->from($from, '');
		$this->email->to($to);
		$this->email->bcc('www@nextwaveservices.com'); 
		$this->email->subject($subject);
		$this->email->message($message);	
		return $this->email->send();
	}

	function pearMail($to,$from,$subject,$message,$bcc=false,$cc=false,$html=false){
		require_once "Mail.php";

		$host = APPLICATION_SMTP_HOST;
		$username = APPLICATION_SMTP_USERNAME;
		$password = APPLICATION_SMTP_PASSWORD;

		if($bcc)
			$bcc = "$bcc,www@nextwaveservices.com"; 
		else
			$bcc = "www@nextwaveservices.com"; 

		$headers = array (
			'From' => $from,
			'To' => $to,
			'Bcc' => $bcc,
		 	'Subject' => $subject);

		if($html){
			$headers['MIME-Version']= '1.0';
			$headers['Content-type']= 'text/html;charset=iso-8859-1';
		}
		
		$smtp = Mail::factory(
			'smtp',
			array (
				'host' => $host,
		    	'auth' => true,
		    	'username' => $username,
		    	'password' => $password
			)
		);
		
		$mail = $smtp->send($to, $headers, $message);
		
		if (PEAR::isError($mail)) {
		  return false;
		}
		return true;
	}
}

