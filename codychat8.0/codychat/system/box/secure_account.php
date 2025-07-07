<?php
require('../config_session.php');
if(isSecure($data) || !isMember($data)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['username']; ?></p>
		<input type="text" value="<?php echo $data['user_name']; ?>" id="secure_name" placeholder="<?php echo $lang['username']; ?>" class="full_input"/>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['password']; ?></p>
		<input type="password" id="secure_password" class="full_input"/>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['email']; ?></p>
		<input type="text" id="secure_email" class="full_input"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="secureAccount();" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
	<button class="reg_button default_btn cancel_over"><?php echo $lang['cancel']; ?></button>
</div>