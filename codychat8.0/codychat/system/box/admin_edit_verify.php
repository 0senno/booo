<?php
require('../config_session.php');
if(!isset($_POST['target']) || !canVerify()){
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);
if(verified($user) || !canEditUser($user, $setting['can_verify'], 0)){
	echo 0;
	die();
}
?>
<div class="modal_content centered_element">
	<div class="vpad15">
		<div class="bold text_med bpad5">
			Verify account
		</div>
		<div class="">
			<?php echo $lang['want_verify']; ?>
		</div>
	</div>
</div>
<div class="modal_control centered_element">
	<button onclick="changeUserVerify(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><?php echo $lang['yes']; ?></button>
	<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
</div>