<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['level_settings']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['use_level']; ?></p>
				<select id="set_use_level">
					<?php echo onOff($setting['use_level']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['level_mode']; ?> <?php echo createInfo('level_mode'); ?></p>
				<select id="set_level_mode">
					<?php echo optionCount($setting['level_mode'], 5, 50, 1); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['exp_chat']; ?></p>
				<select id="set_exp_chat">
					<?php echo optionCount($setting['exp_chat'], 0, 10, 1, $lang['xp']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['exp_priv']; ?></p>
				<select id="set_exp_priv">
					<?php echo optionCount($setting['exp_priv'], 0, 10, 1, $lang['xp']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['exp_post']; ?></p>
				<select id="set_exp_post">
					<?php echo optionCount($setting['exp_post'], 0, 10, 1, $lang['xp']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['exp_gift']; ?></p>
				<select id="set_exp_gift">
					<?php echo optionCount($setting['exp_gift'], 0, 10, 1, $lang['xp']); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminLevel();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
		</div>
	</div>
</div>