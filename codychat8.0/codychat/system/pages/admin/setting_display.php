<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['display']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['theme']; ?></p>
				<select id="set_main_theme">
					<?php echo listTheme($setting['default_theme'], 1); ?>
				</select>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['login_page']; ?></p>
				<select id="set_login_page">
					<?php echo listLogin(); ?>
				</select>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['use_gender']; ?></p>
				<select id="set_use_gender">
					<?php echo yesNo($setting['use_gender']); ?>
				</select>
			</div>
			<div class="setting_element">
				<p class="label"><?php echo $lang['use_flag']; ?></p>
				<select id="set_use_flag">
					<?php echo yesNo($setting['use_flag']); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminDisplay();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
		</div>
	</div>
</div>