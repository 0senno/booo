<?php
require('../config_session.php');
if(!boomAllow(1)){
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['actual_pass']; ?></p>
		<input id="set_actual_pass" class="full_input" maxlength="30" type="password"/>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['new_pass']; ?></p>
		<input id="set_new_pass" class="full_input"  maxlength="30" type="password"/>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['repeat_pass']; ?></p>
		<input id="set_repeat_pass" class="full_input" maxlength="30" type="password"/>
	</div>
</div>
<div class="modal_control">
	<button type="button" id="change_password" onclick="changePassword();" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
</div>