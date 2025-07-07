<?php
require('../config_session.php');
if(!isset($_POST['target']) || !boomAllow($setting['can_rank'])){
	die();
}
$target = escape($_POST['target'], true);
$user = userDetails($target);
if(!canRankUser($user)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<p class="label"><?php echo $lang['user_rank']; ?></p>
	<select id="profile_rank" onchange="changeRank(this, <?php echo $user['user_id']; ?>);">
		<?php echo changeRank($user); ?>
	</select>
</div>