<html>
	<head>
		<STYLE type=Ótext/cssÓ>
			.ReadMsgBody
			{ width: 100%;}
			.ExternalClass
			{width: 100%;}
		</STYLE>
	</head>
	<body bgcolor="#d4e6f6" style="font-family:Tahoma,arial, san-serif;">
	<table cellpadding="0" width="100%" cellspacing="0"><tr><td bgcolor="#d4e6f6">
		<center>
			<br />
			<table cellpadding="0" cellspacing="0" width="518">				<tr>
				<tr>
					<td style="font-family:verdana, san-serif;padding:30px 20px; font-size:16px; color:#5689bc;">
						A new message has been posted on<br>
						<a style="font-weight:bold;font-size:17px; color:#5689bc; margin-top:5px;" href="<?php echo $url."/pet-tales/$story_id"?>"><?php echo $story_pet_name; ?>'s Pet Tale</a>
					</td>
				</tr>
				<tr>
					<td>
						<img hspace="0" vspace="0" style="display:block;margin:0;" border="0" src="http://petpassages.com/site-images/tale_message_email_top.png" width="518" height="5" />
					</td>
				</tr>
				<tr>
					<td bgcolor="#ffffff" style="font-family:verdana, san-serif;padding:30px; background-color:#ffffff; font-size:18px; color:#0b5784;">
						"<?php echo $tribute_message; ?>"
						<p style="font-weight:bold;font-size:18px; color:#0b5784;margin-top:10px;">&#8212;<?php echo $tribute_name; ?></p>
					</td>
				</tr>
				<tr>
					<td>
						<img hspace="0" vspace="0" style="display:block;margin:0;" border="0" src="http://petpassages.com/site-images/tale_message_email_bottom.png" width="518" height="105" />
					</td>
				</tr>
			</table>
		<br />
		<span style="font-size:11px;font-family:verdana, san-serif; color:#366b9f;"><a style="color:#366b9f;" title="Unsubscribe" href="<?php echo $url."/pet-tales/unsubscribe/$story_id?h=$subscriber_hash#unsubscribe"?>">Unsubscribe</a>  |  <a style="color:#366b9f;" title="Sender Info" href="<?php echo $url;?>">Sender Info</a><br />
		<span style="font-size:11px;font-family:verdana, san-serif; color:#366b9f;">This email was sent to you because you subscribed to this pet tale.</span><br /><br />
		</center>
		</td></tr></table>
	</body>
</html>
