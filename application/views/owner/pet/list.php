<div class="owner_pet_wrapper">
	<h2 class="page-title">My Pets</h2>
		<?php if($pets) { ?>
			<ul class='owner_pet_list'>
			<?php 
			foreach($pets as $p) {
				
				if(isset($p['widgets']['34']['widgetPrefs']['petName']))
					$petName = $p['widgets']['34']['widgetPrefs']['petName']['value'];
				else
					$petName = "Pet Name Not Given";
				
				$orderID = $p['orderID'];
				$invoiceID = $p['invoiceNumber'];
				
				if($p['currentPet'])
					$currentPet = " <strong>Current Pet's Passage</stong>";
				else
					$currentPet = "";
				
				echo "<li><a href='/owner/pet/$orderID'><span class='owner_pet_list_title'>{$petName}</span><span class='owner_pet_list_sub'>Secure ID: {$invoiceID} $currentPet</span></a></li>";
			}
			?>
		</ul>
	<?php }else{ ?>
		<p class="owner_message_box">There are currently no pets affiliated with this account.</p>
	<?php } ?>
</div>