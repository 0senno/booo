<?php 
require('../config_session.php');
if(!isset($_POST['target'])){
	echo 0;
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);

if(!canModifyName($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<p class="label"><?php echo $lang['username']; ?></p>
	<input type="text" id="new_user_username" value="<?php echo $user['user_name']; ?>" class="full_input"/>
</div>
<div class="modal_control">
	<button onclick="adminSaveName(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>