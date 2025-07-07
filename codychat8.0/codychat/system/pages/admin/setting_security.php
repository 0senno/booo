<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['security']); ?>
<div class="page_full">
	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="secutab" data-z="system_captcha"><?php echo $lang['captcha']; ?></li>
				<li class="tab_menu_item" data="secutab" data-z="system_flood"><?php echo $lang['flood_setting']; ?></li>
				<li class="tab_menu_item" data="secutab" data-z="system_vpn"><?php echo $lang['vpn_setting']; ?></li>
				<li class="tab_menu_item" data="secutab" data-z="system_rate"><?php echo $lang['rate_limiting']; ?></li>
			</ul>
		</div>
	</div>
	<div class="page_element">
		<div id="secutab">
			<div id="system_captcha" class="tab_zone">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['use_recapt']; ?> <?php echo createInfo('captcha'); ?></p>
						<select id="set_use_recapt">
							<option <?php echo selCurrent($setting['use_recapt'], 0); ?> value="0"><?php echo $lang['none']; ?></option>
							<option <?php echo selCurrent($setting['use_recapt'], 1); ?> value="1">Google reCaptcha</option>
							<option <?php echo selCurrent($setting['use_recapt'], 2); ?> value="2">hCaptcha</option>
							<option <?php echo selCurrent($setting['use_recapt'], 3); ?> value="3">Cloudflare Turnstile</option>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['recapt_site']; ?></p>
						<input id="set_recapt_key" class="full_input" value="<?php echo $setting['recapt_key']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['recapt_secret']; ?></p>
						<input id="set_recapt_secret" class="full_input" value="<?php echo $setting['recapt_secret']; ?>" type="text"/>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminSecurity();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="system_vpn" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['use_vpn']; ?> <?php echo createInfo('proxycheck'); ?></p>
						<select id="set_use_vpn">
							<?php echo onOff($setting['use_vpn']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['pcheck_api']; ?></p>
						<input id="set_vpn_key" class="full_input" value="<?php echo $setting['vpn_key']; ?>" type="text"/>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['vpn_delay']; ?></p>
						<select id="set_vpn_delay">
							<?php echo optionMinutes($setting['vpn_delay'], array(1,2,3,4,5,10,15,30,60)); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminSecurity();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="system_flood" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['flood_action']; ?></p>
						<select id="set_flood_action">
							<option <?php echo selCurrent($setting['flood_action'], 1); ?> value="1"><?php echo $lang['kick']; ?></option>
							<option <?php echo selCurrent($setting['flood_action'], 2); ?> value="2"><?php echo $lang['mute']; ?></option>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['max_flood']; ?> <?php echo createInfo('flood'); ?></p>
						<select id="set_max_flood">
							<?php echo optionCount($setting['max_flood'], 4, 20, 1); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['flood_delay']; ?></p>
						<select id="set_flood_delay">
							<?php echo optionMinutes($setting['flood_delay'], array(1,2,5,10,15,30,60)); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminSecurity();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="system_rate" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['use_rate']; ?> <?php echo createInfo('rate_limit'); ?></p>
						<select id="set_use_rate">
							<?php echo onOff($setting['use_rate']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['rate_limit']; ?></p>
						<select id="set_rate_limit">
							<?php echo optionCount($setting['rate_limit'], 30, 100, 5); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminSecurity();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>