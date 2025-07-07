<?php
require('../config_session.php');

$target = escape($_POST['target'], true);
$user = userDetails($target);

if(!isStaff($data)){
	echo 0;
	die();
}
if(empty($user)){
	echo 0;
	die();
}
if(!canNote($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="tpad15">
		<textarea id="set_user_note" class="xlarge_textarea about_area full_textarea" spellcheck="false" maxlength="10000" ><?php echo getUserData($user, 'user_note'); ?></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="adminSaveNote(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>