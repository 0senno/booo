<?php
require('../config_session.php');
if(!isset($_POST['target'])){
	die();
}
if(!canEditRoom()){
	die();
}

$target = escape($_POST['target'], true);
$user = userRoomDetails($target);

if(!canRoomAction($user, 6)){
	die();
}
?>
<div class="modal_content">
	<p class="label"><?php echo $lang['room_rank']; ?></p>
	<select onChange="changeRoomRank(<?php echo $user['user_id']; ?>);" id="room_staff_rank">
		<?php echo listRoomRank($user['room_ranking']); ?>
	</select>
</div>