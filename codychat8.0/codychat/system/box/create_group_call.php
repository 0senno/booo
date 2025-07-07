<?php
require('../config_session.php');

if(!canCreateGroupCall()){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['room_name']; ?></p>
		<input id="set_call_name" class="full_input" type="text" maxlength="30" />
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['password']; ?> <span class="theme_color text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<input  id="set_call_password" class="full_input" type="text" maxlength="20"/>
	</div>
	<div class="setting_element">	
		<p class="label"><?php echo $lang['room_type']; ?></p>
		<select  class="select_room"  id="set_call_access">
			<?php echo listRoomAccess(); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button class="reg_button theme_btn" onclick="addGroupCall();" id="add_group_call"><?php echo $lang['create']; ?></button>
	<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
</div>