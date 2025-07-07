<?php
require('../config_session.php');
if(!isset($_POST['mute'])){
	die();
}
if(!canMute()){
	die();
}
$target = escape($_POST['mute'], true);
$user = userDetails($target);

if(!canMuteUser($user)){
	return 0;
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['duration']; ?></p>
		<select id="mute_delay">
			<?php echo optionMinutes(5, muteValues()); ?>
		</select>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['reason']; ?> <span class="sub_text text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<textarea id="mute_reason" maxlength="300" class="full_textarea small_textarea" type="text"/></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="privateMuteUser(<?php echo $user['user_id']; ?>);" class="reg_button delete_btn"><?php echo $lang['mute']; ?></button>
	<button class="close_over reg_button default_btn"><?php echo $lang['cancel']; ?></button>
</div>