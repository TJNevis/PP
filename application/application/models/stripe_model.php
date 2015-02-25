<?php
class Stripe_model extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        //Load Stripe Library
        $this->load->library( 'stripe' );

        //Set Api Key
		// $stripe = array(
		//     'secret_key'      => $this->config->item('stripe_test_private_key'),
		//     'publishable_key' => $this->config->item('stripe_test_public_key'),
	 	//    );
		$stripe = array(
            'secret_key'      => $this->config->item('stripe_live_private_key'),
            'publishable_key' => $this->config->item('stripe_live_public_key'),
         );

	    //Initiate
	    Stripe::setApiKey($stripe['secret_key']);
    }

	function chargeCustomer($data,$key){
		try {
			//charge card
			return Stripe_Charge::create($data,$key);

		} catch (Exception $e) {
			$this->messages->add($e->getMessage(), 'error');
			return false;
		}
	}
}
