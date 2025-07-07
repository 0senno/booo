<?php
require('../config_session.php');
if(!isset($_POST['ghost'])){
	die();
}
if(!canGhost()){
	die();
}
$target = escape($_POST['ghost'], true);
$user = userDetails($target);

if(!canGhostUser($user)){
	return 0;
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['duration']; ?></p>
		<select id="ghost_delay">
			<?php echo optionMinutes(5, ghostValues()); ?>
		</select>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['reason']; ?> <span class="sub_text text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<textarea id="ghost_reason" maxlength="300" class="full_textarea small_textarea" type="text"/></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="ghostUser(<?php echo $user['user_id']; ?>);" class="reg_button delete_btn"><?php echo $lang['ghost']; ?></button>
	<button class="close_over reg_button default_btn"><?php echo $lang['cancel']; ?></button>
</div>