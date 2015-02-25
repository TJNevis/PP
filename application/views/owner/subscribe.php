<?php 
$ownerInfo = $this->session->userdata('owner_info');
?>
<div class="owner_pet_wrapper">
	<h2 class="page-title">10 Days of Grieving</h2>
	<?php if(isset($message)){
		echo "<p>$message</p>";
	}else{
	?>
		<form method="post">
<p><img src="http://upload.nws.co/file/148afce55633abc310a1d31f1a17ba7b" alt="" width="200" style="float:right;margin:0 0 10px 10px" /></p>
<p>Given the intense bond most of us share with our animals, it&rsquo;s natural to feel devastated by feelings of grief and sadness when a pet dies. While some people may not understand the depth of feeling you had for your pet, you should never feel guilty or ashamed about grieving for an animal friend. Instead, use these healthy ways to cope with the loss, comfort yourself and others, and begin the process of moving on.</p>
<h3>Understanding grief after the loss of a pet</h3>
<p>For many people a pet is not &ldquo;just a dog&rdquo; or &ldquo;just a cat.&rdquo; Pets are beloved members of the family and, when they die, you feel a significant, even traumatic loss. The level of grief depends on factors such as your age and personality, the age of your pet, and the circumstances of their death. Generally, the more significant the loss, the more intense the grief you&rsquo;ll feel.Grief can be complicated by the role the animal played in your life. For example, if your pet was a working dog or a helper animal such as a guide dog, then you&rsquo;ll not only be grieving the loss of a companion but also the loss of a coworker or the loss of your independence. If you cared for your pet through a protracted illness, you likely grew to love him even more. If you lived alone and the pet was your only companion, coming to terms with his loss can be even harder. If you were unable to afford expensive veterinary treatment to prolong the life of your pet, you may even feel a profound sense of guilt.</p>
<h3>Everyone grieves differently</h3>
<p>Grieving is a personal and highly individual experience. Some people find grief comes in stages, where they experience different feelings such as denial, anger, guilt, depression, and eventually acceptance and resolution. Others find that grief is more cyclical, coming in waves, or a series of highs and lows. The lows are likely to be deeper and longer at the beginning and then gradually become shorter and less intense as time goes by. Still, even years after a loss, a sight, a sound, or a special anniversary can spark memories that trigger a strong sense of grief.</p>
<ul>
<li><strong>The grieving process happens only gradually.</strong> It can&rsquo;t be forced or hurried&mdash;and there is no &ldquo;normal&rdquo; timetable for grieving. Some people start to feel better in weeks or months. For others, the grieving process is measured in years. Whatever your grief experience, it&rsquo;s important to be patient with yourself and allow the process to naturally unfold.</li>
<li><strong>Feeling sad, frightened, or lonely is a normal reaction to the loss of a beloved pet.</strong> Exhibiting these feelings doesn&rsquo;t mean you are weak, so you shouldn&rsquo;t feel ashamed.</li>
<li><strong>Trying to ignore your pain or keep it from surfacing will only make it worse in the long run.</strong> For real healing, it is necessary to face your grief and actively deal with it. By expressing your grief, you&rsquo;ll likely need less time to heal than if you withhold or &ldquo;bottle up&rdquo; your feelings. Write about your feelings and talk with others about them.</li>
</ul>
<h3>Dealing with the loss of a pet when others devalue your loss</h3>
<p>One aspect that can make grieving for the loss of a pet so difficult is that pet loss is not appreciated by everyone. Friends and family may ask &ldquo;What&rsquo;s the big deal? It&rsquo;s just a pet!&rdquo; Some people assume that pet loss shouldn&rsquo;t hurt as much as human loss, or that it is somehow inappropriate to grieve for an animal. They may not understand because they don&rsquo;t have a pet of their own, or because they are unable to appreciate the companionship and love that a pet can provide.</p>
<ul>
<li>Don&rsquo;t argue with others about whether your grief is appropriate or not.</li>
<li>Accept the fact that the best support for your grief may come from outside your usual circle of friends and family members.</li>
<li>Seek out others who have lost pets; those who can appreciate the magnitude of your loss, and may be able to suggest ways of getting through the grieving process.</li>
</ul>
<p>Grief is a journey you must endure after the loss of a loved one and friend. It's easy to become overwhelmed as you work through the phases and tasks of grief, so it's important to rememberto care for yourself.</p>
<p><strong>If you would like to receive a daily inspirational quote and a tip on healthy grieving for the next 10 days, please click subscribe below.</strong></p><br />
			<a class="owner_button" href="javascript:jQuery('form').submit();" title="Subscribe"><span>Subscribe <?php echo $ownerInfo['owner_email']; ?></span></a>
			<input type="hidden" name="subscription" value="true" />
		</form>
	<?php } ?>
</div>
