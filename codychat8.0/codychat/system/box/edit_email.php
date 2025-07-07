<?php
require('../config_session.php');
if(!isMember($data)){ 
	die();
}
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['email']; ?></p>
		<input id="set_profile_email" value="<?php echo $data['user_email']; ?>" class="full_input"/>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['password']; ?></p>
		<input id="email_password" type="password" class="full_input"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="saveEmail();" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>