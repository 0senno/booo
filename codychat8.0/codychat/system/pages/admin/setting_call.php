<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['call_settings']); ?>
<div class="page_full">
	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="call_tab" data-z="call_zone"><?php echo $lang['settings']; ?></li>
				<li class="tab_menu_item" data="call_tab" data-z="calla_zone"><?php echo 'Api' ?></li>
				<li class="tab_menu_item" data="call_tab" data-z="callm_zone"><?php echo $lang['one_call']; ?></li>
				<li class="tab_menu_item" data="call_tab" data-z="callg_zone"><?php echo $lang['group_call']; ?></li>
			</ul>
		</div>
	</div>
	<div id="call_tab">
		<div id="call_zone" class="tab_zone">
			<div class="page_element">
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['use_call']; ?> <?php echo createInfo('video_call'); ?></p>
						<select id="set_use_call">
							<option <?php echo selCurrent($setting['use_call'], 0); ?> value="0"><?php echo $lang['off']; ?></option>
							<option <?php echo selCurrent($setting['use_call'], 1); ?> value="1">Agora</option>
							<option <?php echo selCurrent($setting['use_call'], 2); ?> value="2">Livekit</option>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['payment_method']; ?></p>
						<select id="set_call_method">
							<option value="1" <?php echo selCurrent($setting['call_method'], 1); ?>><?php echo $lang['gold']; ?></option>
							<option value="2" <?php echo selCurrent($setting['call_method'], 2); ?>><?php echo $lang['ruby']; ?></option>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['call_acost']; ?></p>
						<select id="set_call_cost">
							<?php echo optionCount($setting['call_cost'], 0, 9, 1); ?>
							<?php echo optionCount($setting['call_cost'], 10, 100, 5); ?>
							<?php echo optionCount($setting['call_cost'], 150, 1000, 50); ?>
							<?php echo optionCount($setting['call_cost'], 1100, 10000, 100); ?>
						</select>
					</div>
				</div>
			</div>
			<div class="page_element">
				<div class="text_med bold bpad15">
					<?php echo $lang['one_call']; ?>
				</div>
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_vcall']; ?></p>
						<select id="set_can_vcall">
							<?php echo listRank($setting['can_vcall']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_acall']; ?></p>
						<select id="set_can_acall">
							<?php echo listRank($setting['can_acall']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['call_max']; ?></p>
						<select id="set_call_max">
							<?php echo optionMinutes($setting['call_max'], array(5,10,15,30,45,60,120,180,360,720,1440)); ?>
						</select>
					</div>
				</div>
			</div>
			<div class="page_element">
				<div class="text_med bold bpad15">
					<?php echo $lang['group_call']; ?>
				</div>
				<div class="form_content">
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_cgcall']; ?></p>
						<select id="set_can_cgcall">
							<?php echo listRank($setting['can_cgcall']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_gcall']; ?></p>
						<select id="set_can_gcall">
							<?php echo listRank($setting['can_gcall']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['can_mgcall']; ?></p>
						<select id="set_can_mgcall">
							<?php echo listRankStaff($setting['can_mgcall']); ?>
						</select>
					</div>
					<div class="setting_element ">
						<p class="label"><?php echo $lang['max_gcall']; ?></p>
						<select id="set_max_gcall">
							<?php echo optionMinutes($setting['max_gcall'], array(60,120,180,240,300,360,720,1440,10080,43200)); ?>
						</select>
					</div>
				</div>
			</div>
			<div class="page_element">
				<button onclick="saveAdminCall();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
			</div>
		</div>
		<div id="calla_zone" class="hide_zone tab_zone">
			<div class="page_element">
				<div class="text_med bold bpad15">
					Agora <?php echo createInfo('agora'); ?>
				</div>
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['call_appid']; ?></p>
						<input id="set_call_appid" class="full_input" value="<?php echo $setting['call_appid']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['call_secret']; ?></p>
						<input id="set_call_secret" class="full_input" value="<?php echo $setting['call_secret']; ?>" type="text"/>
					</div>
				</div>
			</div>
			<div class="page_element">
				<div class="text_med bold bpad15">
					Livekit <?php echo createInfo('livekit'); ?>
				</div>
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['live_url']; ?></p>
						<input id="set_live_url" class="full_input" value="<?php echo $setting['live_url']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['live_appid']; ?></p>
						<input id="set_live_appid" class="full_input" value="<?php echo $setting['live_appid']; ?>" type="text"/>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['live_secret']; ?></p>
						<input id="set_live_secret" class="full_input" value="<?php echo $setting['live_secret']; ?>" type="text"/>
					</div>
				</div>
			</div>
			<div class="page_element">
				<button onclick="saveAdminCall();" type="button" class="reg_button theme_btn "><?php echo $lang['save']; ?></button>
			</div>
		</div>
		<div id="callm_zone" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="bpad15">
					<button onclick="reloadAdminCall();" type="button" class="reg_button theme_btn "><i class="fa fa-reload"></i><i class="fa fa-refresh"></i> <?php echo $lang['reload']; ?></button>
				</div>
				<div id="admin_calls">
				<?php echo listAdminCall(); ?>
				</div>
			</div>
		</div>
		<div id="callg_zone" class="tab_zone hide_zone">
			<div class="page_element">
				<div class="bpad15">
					<button onclick="reloadAdminGroupCall();" type="button" class="reg_button theme_btn "><i class="fa fa-reload"></i><i class="fa fa-refresh"></i> <?php echo $lang['reload']; ?></button>
				</div>
				<div id="admin_group_calls">
				<?php echo listAdminGroupCall(); ?>
				</div>
			</div>
		</div>
	</div>
</div>