<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['delays']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['innactive_logout']; ?></p>
				<select id="set_act_delay">
					<option value="0"><?php echo $lang['never']; ?></option>
					<?php echo optionMinutes($setting['act_delay'], array(5,10,15,30,60,120,180,360,720,1440,2880,10080)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['chat_delete']; ?></p>
				<select id="set_chat_delete">
					<option value="0"><?php echo $lang['never']; ?></option>
					<?php echo optionMinutes($setting['chat_delete'], array(30,60,180,360,720,1440,2880,4320,5760,7200,8640,10080,20160,43200,86400,129600,525600)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['private_delete']; ?></p>
				<select id="set_private_delete">
					<option value="0"><?php echo $lang['never']; ?></option>
					<?php echo optionMinutes($setting['private_delete'], array(30,60,180,360,720,1440,2880,4320,5760,7200,8640,10080,20160,43200,86400,129600,525600)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['wall_delete']; ?></p>
				<select id="set_wall_delete">
					<option value="0"><?php echo $lang['never']; ?></option>
					<?php echo optionMinutes($setting['wall_delete'], array(1440,2880,4320,5760,7200,8640,10080,43200,86400,129600,525600)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['member_delete']; ?></p>
				<select id="set_member_delete">
					<option value="0"><?php echo $lang['never']; ?></option>
					<?php echo optionMinutes($setting['member_delete'], array(10080,20160,43200,86400,129600, 259200, 525600)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['room_delete']; ?></p>
				<select id="set_room_delete">
					<option value="0"><?php echo $lang['never']; ?></option>
					<?php echo optionMinutes($setting['room_delete'], array(60,120,180,360,720,1440,2880,4320,5760,7200,8640,10080,20160,43200,86400,129600)); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['ignore_delete']; ?></p>
				<select id="set_ignore_delete">
					<option value="0"><?php echo $lang['never']; ?></option>
					<?php echo optionMinutes($setting['ignore_delete'], array(10080,20160,43200,86400,129600,259200,525600)); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminDelays();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
		</div>
	</div>
</div>