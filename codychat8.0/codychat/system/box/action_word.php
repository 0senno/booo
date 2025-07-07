<?php
require('../config_session.php');

if(!boomAllow(100)){
	die();
}
?>
<div class="modal_content">
	<div class="setting_element ">
		<p class="label"><?php echo $lang['take_action']; ?></p>
		<select id="set_word_action">
			<option <?php if($setting['word_action'] == 0){ echo 'selected'; } ?> value="0"><?php echo $lang['action_none']; ?></option>
			<option <?php if($setting['word_action'] == 2){ echo 'selected'; } ?> value="2"><?php echo $lang['mute']; ?></option>
			<option <?php if($setting['word_action'] == 3){ echo 'selected'; } ?> value="3"><?php echo $lang['kick']; ?></option>
		</select>
	</div>
	<div id="word_action_delay" class="setting_element">
		<p class="label"><?php echo $lang['duration']; ?></p>
		<select id="set_word_delay">
			<?php echo optionMinutes($setting['word_delay'], array(1,2,3,4,5,10,15,30,60)); ?>
		</select>
	</div>
</div>
<div class="modal_control">
	<button type="button" onclick="setWordAction();" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
</div>