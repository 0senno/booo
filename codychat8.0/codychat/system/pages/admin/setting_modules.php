<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['manage_module']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['use_like']; ?></p>
				<select id="set_use_like">
					<?php echo onOff($setting['use_like']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['room_system']; ?></p>
				<select id="set_use_lobby">
					<?php echo onOff($setting['use_lobby']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['wall_system']; ?></p>
				<select id="set_use_wall">
					<?php echo onOff($setting['use_wall']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['use_geo']; ?></p>
				<select id="set_use_geo">
					<?php echo onOff($setting['use_geo']); ?>
				</select>
			</div>
			<div class="setting_element ">
				<p class="label"><?php echo $lang['cookie_system']; ?></p>
				<select id="set_cookie_law">
					<?php echo onOff($setting['cookie_law']); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminModules();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
		</div>
	</div>
</div>