<?php
require('../config_session.php');

if(!canEditRoom()){
	die();
}
$room = roomDetails($data['user_roomid']);
$room_owner = getRoomStaff($data['user_roomid'], 6);
$room_admin = getRoomStaff($data['user_roomid'], 5);
$room_mod   = getRoomStaff($data['user_roomid'], 4);

?>
<div class="modal_content">
	<div id="mroom_staff" class="tpad10">
		<?php if(empty($room_owner . $room_admin . $room_mod)){ ?>
			<div class="ulist_container">
			<?php echo emptyZone($lang['no_data']); ?>
			</div>
		<?php } ?>
		<?php if(!empty($room_owner . $room_admin . $room_mod)){ ?>
		<div class="ulist_container">
			<?php echo $room_owner; ?>
			<?php echo $room_admin; ?>
			<?php echo $room_mod; ?>
		</div>
		<?php } ?>
	</div>
</div>