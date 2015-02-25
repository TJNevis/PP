<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.0.1/jquery.payment.min.js"></script>
<script type="text/javascript">
  Stripe.setPublishableKey('<?php echo $this->session->userdata('stripe_public_key'); ?>');
</script>
<div class="owner_pet_wrapper">
	<h2 class="page-title">Online Payment</h2>
<?php 
//get logged in user info
$user = $this->session->userdata('user_info');
$site_license = $this->session->userdata('license');
?>
<script type="text/javascript">
var paymentComplete = false;
jQuery(document).ready(function(){
  jQuery("#payment-form").validate();
  //jQuery('.cc-number').payment('formatCardNumber');
  //jQuery('.cc-cvc').payment('formatCardCVC');


  jQuery('#payment-form').submit(function(event) {

  	if(paymentComplete)
  		return true;
  	
    var $form = jQuery(this);

	//var cardType = $.payment.cardType($('.cc-number').val());

    //jQuery('.cc-number').toggleClass('invalid', !$.payment.validateCardNumber($('.cc-number').val()));
    //jQuery('.cc-cvc').toggleClass('invalid', !$.payment.validateCardCVC($('.cc-cvc').val(), cardType));

    // Disable the submit button to prevent repeated clicks
    if(jQuery("#payment-form").valid()){
	    $form.find('.owner_button').prop('disabled', true);
	    $form.find('.owner_button').val("Submitting...");

	    Stripe.card.createToken($form, function(status, response){
	    	if (response.error) {
			    // Show the errors on the form
			    alert(response.error.message);
			    $form.find('.owner_button').prop('disabled', false);
			    $form.find('.owner_button').val("Complete Payment");
			}else{
			    // token contains id, last4, and card type
			    var token = response.id;
			    // Insert the token into the form so it gets submitted to the server
			    $form.append(jQuery('<input type="hidden" name="stripeToken" />').val(token));
			    // and submit

			    
		    	paymentComplete = true;
		   		//$form.submit();
		   		jQuery('#payment-form').submit();
	    		
	    	}
	    });
	}

    // Prevent the form from submitting with the default action
    return false;
  });

});
</script>
<div class="owner_form">
	<form method="post" id="payment-form" name="payment" action="">
		<fieldset>
			<h3>Invoice Information</h3>
			<div class="invoice-list">
				<ol>
				<table>
					<thead>
						<tr>
							<th>Item</th>
							<th>Price</th>
						</tr>	
					</thead>
					<tbody>
						<?php 
							foreach ($items as  $i) {
								$itemPrice = money_format('%i', $i['price']);
								echo "<tr><td>{$i['service']} - {$i['product']}</td><td class='invoice-item-price'>&#36;{$itemPrice}</td></tr>";
							}
						?>
						<tr>
							<td colspan="2" class="invoice-totals">
								Subtotal: $<?php echo money_format('%i', $subTotalPayment); ?><br />
								Tax: $<?php echo money_format('%i', $totalTax); ?><br />
								<strong>Total: $<?php echo money_format('%i', $totalPayment); ?></strong>
							</td>
						</tr>
					</tbody>
				</table>
			</ol>
			</div>
		</fieldset>
		<fieldset>
			<h3>Billing Information</h3>
			<ol>
				<li><label for="card_first_name">Name on Card</label><input type="text" class="required" name="card_first_name" id="card_first_name" value="" data-stripe="name"/></li>
				<li><label for="card_zip">Billing Zip Code</label><input type="text" class="required input_small" name="card_zip" id="card_zip" value="" data-stripe="address_zip" /></li>
				<li><label for="card_num">Card Number</label><input data-stripe="number" type="text" class="required cc-number" name="card_num" id="card_num" value="" autocomplete="off" /></li>
				<li>
					<label for="card_expiration_month">Card Expiration</label>
					<select name="card_expiration_month" data-stripe="exp-month" class="required">
						<?php 
						for($i=1;$i<=12;$i++){
							if(strlen($i)==1)
								$month = "0".$i;
							else
								$month = $i;
							echo "<option value='$month'>$month</option>";

						}
						?>
					</select>
					<select name="card_expiration_year" data-stripe="exp-year" class="required">
						<?php
						$currentYear = date('Y');
						for($i=0;$i<=8;$i++){
								$year = $i+$currentYear;
							echo "<option value='$year'>$year</option>";

						}
						?>
					</select>
				</li>
				<li><label for="card_code">Card Code/CVV</label><input data-stripe="cvc" type="text" class="required input_small cc-cvc" name="card_code" id="card_code" value="" autocomplete="off" /></li>
			</ol>
		</fieldset>

		<input type="submit" class="owner_button" value="Complete Payment" name="submit-btn" /> (Your card will be charged.)
	</form>
</div>

</div>