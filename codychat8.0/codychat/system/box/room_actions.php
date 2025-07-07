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
	<div class="modal_menu modal_mborder">
		<ul>
			<li class="modal_menu_item modal_selected" data="mroom_setting" data-z="room_muted"><?php echo $lang['muted']; ?></li>
			<li class="modal_menu_item" data="mroom_setting" data-z="room_blocked"><?php echo $lang['blocked']; ?></li>
		</ul>
	</div>
	<div id="mroom_setting" class="tpad20">
		<div class="modal_zone" id="room_muted">
			<div class="ulist_container">
				<?php echo getRoomMuted($data['user_roomid']); ?>
			</div>
		</div>
		<div class="modal_zone hide_zone" id="room_blocked">
			<div class="ulist_container">
				<?php echo getRoomBlocked($data['user_roomid']); ?>
			</div>
		</div>
	</div>
</div>