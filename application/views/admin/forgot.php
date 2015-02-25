<?php
$attributes = array('class' => 'form', 'id' => 'login-form');
echo "<p>Please type in your email address or username to continue. <br />Forgot your username? Please contact us at support@petpassages.com</p>";
echo form_open('',$attributes);
echo "<div class='input'>";
echo form_label('Username', 'username');

echo form_input('username', '');
echo "</div><p class='or'>-- or --</p><div class='input'>";
echo form_label('Email', 'email');
echo form_input('email', '');
echo "</div><div class='input'>";
echo form_submit('mysubmit', 'Send Instructions');
echo "</div>";
echo form_close('');
?>