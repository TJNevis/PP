<div class="owner_pet_wrapper">
	<h2 class="page-title">My Pet Tales</h2>

	<?php 
	$ownerSettings = $this->session->userdata('owner_settings');
	if($ownerSettings['pet_tales_text']){
		$talesText = $ownerSettings['pet_tales_text'];
	}else{
		$talesText = $this->config->item('pet_tales_text_default');
	}
	echo $talesText;
	?>
	<?php if(!$tales){ ?>
		<p class="owner_message_box">You have not added Pet Tales yet. You may add a new Pet Tale by clicking the button below.</p>
	<?php } ?>
	<a class="owner_button owner_add" href="/owner/pet-tales/edit/"><span>Add New Pet Tale</span></a>
	<ul class='owner_pet_list'>
		<?php 
			foreach($tales as $t){
				$messageCount = count($t['story_messages']);
				echo "<li><a href='/owner/pet-tales/edit/{$t['story_id']}'><span class='owner_pet_list_title'>{$t['story_pet_name']}</span><span class='owner_pet_list_sub'>{$messageCount} messages</span></a></li>";
			}
		?>
	</ul>
</div>