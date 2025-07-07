<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);
if(!canModifyPassword($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<p class="label"><?php echo $lang['password']; ?></p>
	<input type="text" id="new_user_password"  class="full_input"/>
</div>
<div class="modal_control">
	<button onclick="adminSavePassword(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>