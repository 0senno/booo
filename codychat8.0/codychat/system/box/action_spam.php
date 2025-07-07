<?php
require('../config_session.php');

if(!boomAllow(100)){
	die();
}
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['take_action']; ?></p>
		<select id="set_spam_action">
			<option <?php if($setting['spam_action'] == 0){ echo 'selected'; } ?> value="0"><?php echo $lang['action_none']; ?></option>
			<option <?php if($setting['spam_action'] == 1){ echo 'selected'; } ?> value="1"><?php echo $lang['mute']; ?></option>
			<option <?php if($setting['spam_action'] == 2){ echo 'selected'; } ?> value="2"><?php echo $lang['ban']; ?></option>
			<option <?php if($setting['spam_action'] == 3){ echo 'selected'; } ?> value="3"><?php echo $lang['ghost']; ?></option>
		</select>
	</div>
	<div id="spam_action_delay" class="setting_element">
		<p class="label"><?php echo $lang['duration']; ?></p>
		<select id="set_spam_delay">
			<?php echo optionMinutes($setting['spam_delay'], array(1,2,3,4,5,10,15,30,60,180,1440,10080)); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button type="button" onclick="setSpamAction();" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
</div>