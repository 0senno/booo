<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['chat_settings']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_main']; ?></p>
				<select id="set_max_main">
					<?php echo optionCount($setting['max_main'], 100, 1000, 100); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_private']; ?></p>
				<select id="set_max_private">
					<?php echo optionCount($setting['max_private'], 100, 500, 50); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_emo']; ?></p>
				<select id="set_max_emo">
					<?php echo optionCount($setting['max_emo'], 1, 20, 1); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_offcount']; ?></p>
				<select id="set_max_offcount">
					<?php echo optionCount($setting['max_offcount'], 0, 100, 5); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['privload']; ?></p>
				<select id="set_privload">
					<?php echo onOff($setting['privload']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['speed']; ?></p>
				<select id="set_speed">
					<?php echo optionCount($setting['speed'], 1500, 5000, 500, 'ms'); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_room']; ?></p>
				<select id="set_max_room">
					<?php echo optionCount($setting['max_room'], 1, 10, 1); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['log_join']; ?></p>
				<select id="set_log_join">
					<?php echo yesNo(useLogs(1)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['log_name']; ?></p>
				<select id="set_log_name">
					<?php echo yesNo(useLogs(2)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['log_action']; ?></p>
				<select id="set_log_action">
					<?php echo yesNo(useLogs(3)); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminChat();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
		</div>
	</div>
</div>