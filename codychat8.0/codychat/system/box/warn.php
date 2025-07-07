<?php
require('../config_session.php');
if(!isset($_POST['warn'])){
	die();
}
if(!canWarn()){
	die();
}
$target = escape($_POST['warn'], true);
$user = userDetails($target);

if(!canWarnUser($user)){
	return 0;
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['message']; ?></p>
		<textarea id="warn_reason" maxlength="300" class="full_textarea small_textarea" type="text"/></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="warnUser(<?php echo $user['user_id']; ?>);" class="reg_button delete_btn"><?php echo $lang['warn']; ?></button>
	<button class="close_over reg_button default_btn"><?php echo $lang['cancel']; ?></button>
</div>