<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends PP_Controller {

	function __construct(){
		
		parent::__construct();
		if(!$this->session->userdata('owner_logged_in') && $this->uri->segment(2) != "login"){
        	redirect('owner/login');
		}

		if(empty($_SERVER['HTTPS']))
			redirect("https://".$this->session->userdata('sub_domain')."/owner/");

    	$this->load->model('Story_model');
   		$this->load->model('Global_model');
    	$this->load->model('Owner_model');
    	$this->load->model('Stripe_model');
    	$this->load->model('Mail_model');
    	$this->load->model('Api_model');
	}
	
	public function index()
	{




		$layoutData = array();
		$petID = $this->uri->segment(3);

		//get account information
		$url = $this->config->item('apiUrl')."/contacts/info";
		$accountInfo = json_decode($this->Api_model->get($url),true);

		$owner = $this->session->userdata('owner_info');
	
		$layoutData['account'] = $accountInfo;

		if($petID){

			$url = $this->config->item('apiUrl')."/orders/info/".$petID;
			$pet = json_decode($this->Api_model->get($url),true);
			//print_r($pet);

			//check if already paid or not yet invoiced 
			if(!$pet['isInvoiced'] || $pet['paid']) {
				$this->messages->add($this->lang->line('owner_payment_unavailable'), 'error');
				redirect("owner/pet/$petID");
			}

			//get invoice data for the pet
			$layoutData['items'] = $pet['products'];


			//calculate total
			$layoutData['subTotalPayment'] = 0;
			$layoutData['totalPayment'] = 0;
			foreach ($layoutData['items'] as $i) {
				$layoutData['subTotalPayment'] += $i['price'];
				$layoutData['totalPayment'] += $i['totalPrice'];
			}

			//calculate fee split
			$layoutData['totalFee'] = $layoutData['subTotalPayment']*$this->config->item('stripe_fee');

			//calculate tax 
			$layoutData['totalTax'] = $layoutData['totalPayment']-$layoutData['subTotalPayment'];

			//post action
			if($this->input->post('stripeToken')){

				//charge card on PP
				$data = array(
					'amount' => $layoutData['totalPayment']*100,
					'card' => $this->input->post('stripeToken'),
					'currency' => "usd",
					'description' => $owner['owner_company_name']." - ".$owner['owner_name'],
					'application_fee' => $layoutData['totalFee']*100
				);
				$charge = $this->Stripe_model->chargeCustomer($data,$this->session->userdata('stripe'));

				//show complete page
				if($charge){
					//build post array
					$bdbPayment = array(
						'totalAmount'=>$layoutData['totalPayment'],
						'orderID'=>$petID,
						'transactionNumber'=>$charge->id,
						'paymentDate'=>date('Y-m-d')
					);

					foreach($layoutData['items'] as $i){
						$bdbPayment['payments'][$i['lineItemID']]=$i['totalPrice'];
					}
					$url = $this->config->item('apiUrl')."/orders/payment";
					$this->Api_model->post($url,$bdbPayment);


					//send receipt / thank you email

					if($accountInfo['prefs']['email']['value']) {
						$emailData = array(
							'name' => $accountInfo['firstName']." ".$accountInfo['lastName'],
							'affiliate' => $this->session->userdata('name'),
							'amount' => "$".money_format('%i', $layoutData['totalPayment']),
							'affiliate_email' => $this->session->userdata('contact_email')
						);

						$emailBody = $this->load->view('emails/owner_payment_confirmation',$emailData,true);
						$this->Mail_model->sendEmail($accountInfo['prefs']['email']['value'],'no_reply@petpassages.com',$this->lang->line('owner_payment_confirmation_subject'),$emailBody,false,$this->session->userdata('contact_email').",mikeharris@harrisfuneralhome.com");
					}

					$this->messages->add($this->lang->line('owner_payment_complete'), 'success');
					redirect("owner/pet/$petID");
				}
			}

			
			$layoutData['tabs'] = true;
			$layoutData['content'] = $this->load->view('owner/payment',$layoutData,true);
			if($this->session->userdata('embed')==true)
	            $this->load->view('layouts/owner_embed',$layoutData);
	        else
				$this->load->view('layouts/owner',$layoutData);
		}else{
			die("No pet provided.");
		}
	}
}
