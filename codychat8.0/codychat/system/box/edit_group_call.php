<?php
require('../config_session.php');

if(!isset($_POST['call_id'])){
	echo 0;
	die();
}
$id = escape($_POST['call_id'], true);
$call = groupCallDetails($id);
if(empty($call)){
	echo 0;
	die();
}
if(!canEditCall($call)){
	echo 0;
	die();
}
?>
<div class="modal_content">
	<div class="setting_element">
		<p class="label"><?php echo $lang['room_name']; ?></p>
		<input id="save_call_name" class="full_input" type="text" maxlength="30" value="<?php echo $call['call_name']; ?>"/>
	</div>
	<?php if(mySelf($call['call_creator'])){ ?>
	<div class="setting_element">
		<p class="label"><?php echo $lang['password']; ?> <span class="theme_color text_xsmall"><?php echo $lang['optional']; ?></span></p>
		<input  id="save_call_password" class="full_input" type="text" maxlength="20" value="<?php echo $call['call_password']; ?>"/>
	</div>
	<?php } ?>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['room_type']; ?></p>
		<select id="save_call_access">
			<?php echo listRoomAccess($call['call_access']); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button class="reg_button theme_btn" onclick="saveGroupCall(<?php echo $call['call_id']; ?>);" id="save_group_call"><?php echo $lang['save']; ?></button>
	<button class="reg_button cancel_over default_btn"><?php echo $lang['cancel']; ?></button>
</div>