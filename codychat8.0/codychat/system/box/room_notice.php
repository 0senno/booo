<?php
require('../config_session.php');
if(!canEditRoom()){
	echo 0;
	die();
}
?>
<div class="centered_element">
	<div class="modal_content">
		<div class="pad15">
			<div class="vpad5">
				<img class="large_icon" src="default_images/icons/congratulation.svg"/>
			</div>
			<p class="text_large bold vpad10"><?php echo $lang['congrats']; ?></p>
			<p><?php echo $lang['config_room']; ?></p>
		</div>
	</div>
	<div class="modal_control">
		<button onclick="openRoomSettings();" class="reg_button theme_btn"><?php echo $lang['yes']; ?></button>
		<button class="reg_button cancel_modal default_btn"><?php echo $lang['no']; ?></button>
	</div>
</div>