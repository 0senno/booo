<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['database_management']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_avatar']; ?></p>
				<select id="set_max_avatar">
					<?php echo optionCount($setting['max_avatar'], 1, 10, 1, 'mb'); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_cover']; ?></p>
				<select id="set_max_cover">
					<?php echo optionCount($setting['max_cover'], 1, 10, 1, 'mb'); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_ricon']; ?></p>
				<select id="set_max_ricon">
					<?php echo optionCount($setting['max_ricon'], 1, 10, 1, 'mb'); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['max_file']; ?></p>
				<select id="set_max_file">
					<?php echo optionCount($setting['file_weight'], 1, 50, 1, 'mb'); ?>
					<?php echo optionCount($setting['file_weight'], 60, 500, 20, 'mb'); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminData();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
		</div>
	</div>
</div>