<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['badge_settings']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['use_badge']; ?></p>
				<select id="set_use_badge">
					<?php echo onOff($setting['use_badge']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['bachat']; ?></p>
				<select id="set_bachat">
					<?php echo optionCount($setting['bachat'], 5, 100, 5); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['bagift']; ?></p>
				<select id="set_bagift">
					<?php echo optionCount($setting['bagift'], 5, 100, 5); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['balike']; ?></p>
				<select id="set_balike">
					<?php echo optionCount($setting['balike'], 5, 100, 5); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['bafriend']; ?></p>
				<select id="set_bafriend">
					<?php echo optionCount($setting['bafriend'], 5, 100, 5); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['baruby']; ?></p>
				<select id="set_baruby">
					<?php echo optionCount($setting['baruby'], 100, 10000, 100); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['bagold']; ?></p>
				<select id="set_bagold">
					<?php echo optionCount($setting['bagold'], 1000, 100000, 1000); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['babeat']; ?></p>
				<select id="set_babeat">
					<?php echo optionCount($setting['babeat'], 100, 10000, 100); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminBadge();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
		</div>
	</div>
</div>