<?php
require('../config_session.php');
$call = '';
$login = '';
$friend = '';
if(!useCall()){
	$call = 'hidden';
}
if(!isMember($data) || !isSecure($data)){
	$login = 'hidden';
}
if(!isMember($data)){
	$friend = 'hidden';
}
?>
<div class="modal_content">
	<div class="setting_element <?php echo $call; ?>">
		<p class="label"><?php echo $lang['call']; ?></p>
		<select id="set_user_call">
			<option <?php echo selCurrent($data['user_call'], 1); ?> value="1"><?php echo $lang['on']; ?></option>
			<?php if(boomAllow(1)){ ?>
			<option <?php echo selCurrent($data['user_call'], 3); ?> value="3"><?php echo $lang['members_only']; ?></option>
			<option <?php echo selCurrent($data['user_call'], 2); ?> value="2"><?php echo $lang['friend_only']; ?></option>
			<?php } ?>
			<option <?php echo selCurrent($data['user_call'], 0); ?> value="0"><?php echo $lang['off']; ?></option>
		</select>
	</div>
	<div class="setting_element ">
		<p class="label"><?php echo $lang['private_mode']; ?></p>
		<select id="set_private_mode">
			<option <?php echo selCurrent($data['user_private'], 1); ?> value="1"><?php echo $lang['on']; ?></option>
			<?php if(boomAllow(1)){ ?>
			<option <?php echo selCurrent($data['user_private'], 3); ?> value="3"><?php echo $lang['members_only']; ?></option>
			<option <?php echo selCurrent($data['user_private'], 2); ?> value="2"><?php echo $lang['friend_only']; ?></option>
			<?php } ?>
			<option <?php echo selCurrent($data['user_private'], 0); ?> value="0"><?php echo $lang['off']; ?></option>
		</select>
	</div>
	<div class="setting_element <?php echo $friend; ?>">
		<p class="label"><?php echo $lang['friend_request']; ?></p>
		<select id="set_ufriend">
			<?php echo onOff($data['ufriend']); ?>
		</select>
	</div>
	<div class="setting_element <?php echo $login; ?>">
		<p class="label"><?php echo $lang['login_allow']; ?></p>
		<select id="set_ulogin">
			<option <?php echo selCurrent($data['ulogin'], 0); ?> value="0"><?php echo $lang['login_all']; ?></option>
			<option <?php echo selCurrent($data['ulogin'], 1); ?> value="1"><?php echo $lang['login_mail']; ?></option>
		</select>
	</div>
</div>
<div class="modal_control">
	<button onclick="savePreference();" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
</div>