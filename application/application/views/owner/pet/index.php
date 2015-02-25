<?php 
$ownerInfo = $this->session->userdata('owner_info');

error_log(print_r($pet,1));


if(isset($pet['widgets']['34']['widgetPrefs']['petName']))
	$petName = $pet['widgets']['34']['widgetPrefs']['petName']['value'];
else
	$petName = "Pet Name Not Given";

?>

<div class="owner_pet_wrapper">
	<h2 class="page-title"><?php echo $petName?>'s Status</h2>
	<?php if($pet) { ?>
	<div class="owner_full">
		<h3 class="owner_header">Status</h3>
		<div class="owner_area">
			<?php echo $petStatusMessage; ?>
		</div>
	</div>
	<div class="owner_full">
		<div class="owner_left">
			<table class="owner_table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>Status History</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($pet['statuses'] as $s) {
					?>
					<tr>
						<td><?php echo $s['status']; ?> - <?php echo $s['message']; ?></td>
						<td><?php echo date('m/d/Y g:ia',$s['date']);  ?>
					</tr>
					<?php 
					}
					?>
				</tbody>
			</table>
		</div>
		<div class="owner_right">
			<?php 

			$ownerSettings = $this->session->userdata('owner_settings');
			
			if(isset($ownerSettings['print_certificate']) && $ownerSettings['print_certificate']=='Off') {
				
			}else{
				echo '<a class="owner_button owner_print" href="/owner/pdf/certificate/'.$orderID.'"><span>Print Certificate</span></a>';
			}	
			
			if(isset($ownerSettings['create_pet_tale']) && $ownerSettings['create_pet_tale']=='Off') {
				
			}else{
				echo '<a class="owner_button owner_add" href="/owner/pet-tales/edit/"><span>Add A Pet Tale</span></a>';
			}
			?>
			<?php if($this->session->userdata('stripe') && !$pet['paid'] && $pet['vetOnlinePayment'] ) {?>
				<a class="owner_button owner_payment" href="/owner/payment/<?php echo $pet['orderID']; ?>"><span>Make a Payment</span></a>
			<?php } ?>
		</div>
	</div>
	<div class="owner_full">
		<h3 class="owner_header">Understanding Status Messages</h3>
		<div class="owner_area">
	<?php 
	$ownerSettings = $this->session->userdata('owner_settings');
	if($ownerSettings['status_message_text']){
		$statusText = $ownerSettings['status_message_text'];
	}else{
		$statusText = $this->config->item('status_message_text_default');
	}
	echo str_replace("{company_name}", $ownerInfo['owner_company_name'], $statusText);
	?>
		</div>
			</div>
	<?php }else{ ?>
		<p class="owner_message_box">There are currently no pets affiliated with this account.</p>
	<?php } ?>
</div>
