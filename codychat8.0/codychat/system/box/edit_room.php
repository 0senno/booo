<?php
require('../config_session.php');

if(!isset($_POST['edit_room']) || !canManageRoom()){
	die();
}
$target = escape($_POST['edit_room'], true);
$room = roomDetails($target);
if(empty($room)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<div class="btable">
			<div id="set_room_icon" class="ricon_current_wrap">
				<img class="ricon_current" src="<?php echo myRoomIcon($room['room_icon']); ?>"/>
				<div class="ricon_control olay">
					<div class="ricon_button" onclick="staffRemoveRoomIcon(<?php echo $room['room_id']; ?>);">
						<i class="fa fa-times"></i>
					</div>
					<div class="ricon_button">
						<i class="fa fa-camera" id="ricon_icon" data="fa-camera"></i>
						<input id="ricon_image" class="up_input" onchange="adminRoomIcon(<?php echo $room['room_id']; ?>);" type="file">
					</div>
				</div>
			</div>
			<div class="bcell">
			</div>
		</div>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['room_name']; ?></p>
		<input id="set_room_name" maxlength="30" class="full_input" value="<?php echo $room['room_name']; ?>" type="text"/>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['room_type']; ?></p>
		<select id="set_room_access">
			<?php echo listRoomAccess($room['access']); ?>
		</select>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['password']; ?></p>
		<input id="set_room_password" maxlength="20" class="full_input" value="<?php echo $room['password']; ?>" type="text"/>
	</div>
	<?php if(usePlayer()){ ?>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['default_player']; ?></p>
		<select id="set_room_player">
			<?php echo adminPlayer($room['room_player_id'], 1); ?>
		</select>
	</div>
	<?php } ?>
	<div class="setting_element">
		<p class="label"><?php echo $lang['room_description']; ?></p>
		<textarea id="set_room_description" class="full_textarea medium_textarea" type="text" maxlength="150"><?php echo $room['description']; ?></textarea>
	</div>
</div>
<div class="modal_control">
	<button data="<?php echo $room['room_id']; ?>" type="button" id="admin_save_room" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
</div>