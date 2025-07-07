<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	die();
}
$target = escape($_POST['target'], true);
$user = userProfileDetails($target);

if(empty($user)){
	echo 0;
	die();
}

if(!canModifyAbout($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['about_me']; ?></p>
		<textarea id="admin_user_about" class="large_textarea about_area full_textarea" spellcheck="false" maxlength="800" ><?php echo $user['user_about']; ?></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="adminSaveAbout(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>