<?php
require('../config_session.php');
if(!isset($_POST['room_block'])){
	die();
}

$target = escape($_POST['room_block'], true);
$user = userRoomDetails($target);

if(!canRoomAction($user, 5, 2)){
	return 0;
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['duration']; ?></p>
		<select id="room_block_delay">
			<?php echo optionMinutes(5, blockValues()); ?>
		</select>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['reason']; ?> <span class="sub_text text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<textarea id="room_block_reason" maxlength="300" class="full_textarea small_textarea" type="text"/></textarea>
	</div>
</div>
<div class="modal_control">
	<button onclick="roomBlockUser(<?php echo $user['user_id']; ?>);" class="reg_button delete_btn"><?php echo $lang['block']; ?></button>
	<button class="close_over reg_button default_btn"><?php echo $lang['cancel']; ?></button>
</div>