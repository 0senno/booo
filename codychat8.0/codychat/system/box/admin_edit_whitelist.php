<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);
if(!canWhitelist($user)){
	echo 0;
	die();
}
if(isGuest($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<p class="label"><?php echo $lang['vpn_check']; ?></p>
	<select id="profile_change_verify" onchange="changeUserVpn(this, <?php echo $user['user_id']; ?>);">
		<?php echo yesNo($user['uvpn']); ?>
	</select>
</div>