<div id="login_form">

	<h1>Login, Fool!</h1>
    <?php 
	echo form_open('welcome/validate_credentials');
	echo form_input('username', 'Username');
	echo form_password('password', 'Password');
	echo form_submit('submit', 'Login');
	echo anchor('welcome/signup', 'Create Account');
	echo form_close();
	?>

</div><!-- end login_form-->
