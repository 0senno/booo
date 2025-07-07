<?php
require('../config_session.php');

if(!isset($_POST['room_rank'], $_POST['room_id'])){
	die();
}
$ar = escape($_POST['room_rank'], true);
$rid = escape($_POST['room_id'], true);
if(!is_numeric($ar) || !is_numeric($rid)){
	die();
}
?>
<div class="centered_element">
	<div class="modal_content">
		<div class="pad15">
			<p class="text_large bold bpad5"><?php echo $lang['pass_title']; ?></p>
			<p><?php echo $lang['pass_message']; ?></p>
		</div>
		<div class="setting_element">
			<input id="pass_input" class="full_input centered_element" type="password"/>
		</div>
	</div>
	<div class="modal_control">
		<button onclick="joinRoomPassword(<?php echo $rid; ?>, <?php echo $ar; ?>);" id="access_room" class="reg_button theme_btn"><?php echo $lang['ok']; ?></button>
		<button class="cancel_over reg_button default_btn"><?php echo $lang['cancel']; ?></button>
	</div>
</div>