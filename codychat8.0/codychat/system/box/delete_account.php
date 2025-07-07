<?php
require('../config_session.php');
if(!isset($_POST['account'])){
	die();
}
$account = escape($_POST['account'], true);
$user = userDetails($account);
if(empty($user)){
	echo 0;
	die();
}
?>
<div class="centered_element">
	<div class="modal_content">
		<div class="vpad15">
			<div class="centered_element">
				<img class="large_avatar brad50" src="<?php echo myAvatar($user['user_tumb']); ?>"/>
			</div>
			<div class="text_large bold bpad15">
				<?php echo $user['user_name']; ?>
			</div>
			<div class="">
				<?php echo $lang['want_delete']; ?>
			</div>
		</div>
	</div>
	<div class="modal_control">
		<button onclick="confirmDelete(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><?php echo $lang['yes']; ?></button>
		<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
	</div>
</div>