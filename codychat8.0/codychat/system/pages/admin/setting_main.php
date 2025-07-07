<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['main_settings']); ?>
<div class="page_full">
	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="main_tab" data-z="main_zone"><?php echo $lang['main']; ?></li>
				<li class="tab_menu_item" data="main_tab" data-z="app_zone"><?php echo $lang['app_settings']; ?></li>
				<li class="tab_menu_item" data="main_tab" data-z="maint_zone"><?php echo $lang['maintenance']; ?></li>
			</ul>
		</div>
	</div>
	<div id="main_tab">
		<div id="main_zone" class="tab_zone">
			<div class="page_element">
				<div class="form_control">
					<div class="setting_element">
						<p class="label"><?php echo $lang['index_path']; ?> <?php echo createInfo('index_path'); ?></p>
						<input id="set_index_path" class="full_input" value="<?php echo $setting['domain']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['site_title']; ?></p>
						<input id="set_title" class="full_input" value="<?php echo $setting['title']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['site_description']; ?></p>
						<input id="set_site_description" class="full_input" value="<?php echo $setting['site_description']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['site_keyword']; ?></p>
						<input id="set_site_keyword" class="full_input" value="<?php echo $setting['site_keyword']; ?>" type="text"/>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['timezone']; ?></p>
						<select id="set_timezone">
							<?php echo getTimezone($setting['timezone']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['default_language']; ?></p>
						<select id="set_default_language">
							<?php echo listLanguage($setting['language'], 1); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminMain();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
		<div id="app_zone" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['use_app']; ?></p>
						<select id="set_use_app">
							<?php echo onOff($setting['use_app']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['app_name']; ?></p>
						<input id="set_app_name" class="full_input" value="<?php echo $setting['app_name']; ?>" type="text"/>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['app_color']; ?></p>
						<input id="set_app_color" class="full_input" value="<?php echo $setting['app_color']; ?>" type="text"/>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminApp();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
		<div id="maint_zone" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['maint_mode']; ?></p>
						<select id="set_maint_mode">
							<?php echo onOff($setting['maint_mode']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminMaintenance();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>