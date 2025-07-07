<?php
require('../config_session.php');
if(!canRoom()){ 
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['room_name']; ?></p>
		<input id="set_room_name" class="full_input" type="text" maxlength="30" />
	</div>
	<div class="setting_element">	
		<p class="label"><?php echo $lang['room_type']; ?></p>
		<select  class="select_room"  id="set_room_type">
			<?php echo listRoomAccess(); ?>
		</select>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['password']; ?> <span class="theme_color text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<input  id="set_room_password" class="full_input" type="text" maxlength="20"/>
	</div>
	<div class="setting_element">
		<p class="label"><?php echo $lang['room_description']; ?> <span class="theme_color text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<textarea id="set_room_description" class="full_textarea medium_textarea" type="text" maxlength="150"></textarea>
	</div>
</div>
<div class="modal_control">
	<button class="reg_button theme_btn" onclick="addRoom();" id="add_room"><i class="fa fa-plus-circle"></i> <?php echo $lang['create']; ?></button>
	<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
</div>