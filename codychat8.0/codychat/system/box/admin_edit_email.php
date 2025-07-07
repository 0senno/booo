<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);
if(!canModifyEmail($user)){
	echo 99;
	die();
}
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['email']; ?></p>
		<input id="set_user_email" value="<?php echo $user['user_email']; ?>" class="full_input"/>
	</div>
</div>
<div class="modal_control">
	<button onclick="adminSaveEmail(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>