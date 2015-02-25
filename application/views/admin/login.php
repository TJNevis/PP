<?php
$attributes = array('class' => 'form', 'id' => 'login-form');
echo form_open('',$attributes);
echo "<div class='input'>";
echo form_label('Username', 'username');
echo form_input('username', '');
echo "</div><div class='input'>";
echo form_label('Password', 'password');
echo form_password('password', '');
echo "</div><p><a href='/admin/forgot'>Forgot password?</a></p><div class='input'>";
echo form_submit('mysubmit', 'Login');
echo "</div>";
echo form_close('');
?>