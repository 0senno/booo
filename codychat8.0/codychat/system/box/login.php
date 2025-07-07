<?php 
require('../config.php');
?>
<div id="login_form_box">
	<div class="modal_title">
		<?php echo $lang['login']; ?>
	</div>
	<div class="modal_content">
		<div class="bpad15">
			<input id="user_username" class="user_username full_input" type="text" maxlength="50" name="username" placeholder="<?php echo $lang['name_email']; ?>">
		</div>
		<div>
			<input id="user_password"  class="full_input" maxlength="30" type="password" name="password" placeholder="<?php echo $lang['password']; ?>">
		</div>
	</div>
	<div class="modal_control">
		<button onclick="sendLogin();" type="button" class="theme_btn full_button large_button"><i class="fa fa-sign-in"></i> <?php echo $lang['login']; ?></button>
		<div class="forgot_pass_elem tpad15">
			<p onclick="getRecovery();" class="forgot_password text_small bclick sub_text"><?php echo $lang['forgot']; ?></p>
		</div>
	</div>
</div>