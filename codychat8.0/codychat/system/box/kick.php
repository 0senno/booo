<?php
require('../config_session.php');
if(!isset($_POST['kick'])){
	die();
}
if(!canKick()){
	die();
}
$target = escape($_POST['kick'], true);
$user = userDetails($target);

if(!canKickUser($user)){
	return 0;
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['duration']; ?></p>
		<select id="kick_delay">
			<?php echo optionMinutes(5, kickValues()); ?>
		</select>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['reason']; ?> <span class="sub_text text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<textarea id="kick_reason" maxlength="300" class="full_textarea small_textarea" type="text"/></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="kickUser(<?php echo $user['user_id']; ?>);" class="reg_button delete_btn"><?php echo $lang['kick']; ?></button>
	<button class="close_over reg_button default_btn"><?php echo $lang['cancel']; ?></button>
</div>