<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['staff_permission']); ?>
<div class="page_full">

	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="staffperm" data-z="staff_act"><?php echo $lang['action']; ?></li>
				<li class="tab_menu_item" data="staffperm" data-z="staff_profile"><?php echo $lang['pro_action']; ?></li>
				<li class="tab_menu_item" data="staffperm" data-z="staff_system"><?php echo $lang['system']; ?></li>
				<li class="tab_menu_item" data="staffperm" data-z="staff_security"><?php echo $lang['display']; ?></li>
				<li class="tab_menu_item" data="staffperm" data-z="staff_other"><?php echo $lang['other']; ?></li>
			</ul>
		</div>
	</div>
	<div class="page_element">
		<div id="staffperm">
			<div id="staff_act" class="tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_mute']; ?></p>
						<select id="set_can_mute">
							<?php echo listRankStaff($setting['can_mute']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_warn']; ?></p>
						<select id="set_can_warn">
							<?php echo listRankStaff($setting['can_warn']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_kick']; ?></p>
						<select id="set_can_kick">
							<?php echo listRankStaff($setting['can_kick']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_ghost']; ?></p>
						<select id="set_can_ghost">
							<?php echo listRankStaff($setting['can_ghost']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_ban']; ?></p>
						<select id="set_can_ban">
							<?php echo listRankStaff($setting['can_ban']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_delete']; ?></p>
						<select id="set_can_delete">
							<?php echo listRankStaff($setting['can_delete']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_rank']; ?></p>
						<select id="set_can_rank">
							<?php echo listRankStaff($setting['can_rank']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_raction']; ?></p>
						<select id="set_can_raction">
							<?php echo listRankStaff($setting['can_raction']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminStaffPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="staff_profile" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modavat']; ?></p>
						<select id="set_can_modavat">
							<?php echo listRankStaff($setting['can_modavat']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modcover']; ?></p>
						<select id="set_can_modcover">
							<?php echo listRankStaff($setting['can_modcover']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modmood']; ?></p>
						<select id="set_can_modmood">
							<?php echo listRankStaff($setting['can_modmood']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modabout']; ?></p>
						<select id="set_can_modabout">
							<?php echo listRankStaff($setting['can_modabout']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modcolor']; ?></p>
						<select id="set_can_modcolor">
							<?php echo listRankStaff($setting['can_modcolor']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modname']; ?></p>
						<select id="set_can_modname">
							<?php echo listRankStaff($setting['can_modname']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modemail']; ?></p>
						<select id="set_can_modemail">
							<?php echo listRankStaff($setting['can_modemail']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modpass']; ?></p>
						<select id="set_can_modpass">
							<?php echo listRankStaff($setting['can_modpass']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modvpn']; ?></p>
						<select id="set_can_modvpn">
							<?php echo listRankStaff($setting['can_modvpn']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_modblock']; ?></p>
						<select id="set_can_modblock">
							<?php echo listRankStaff($setting['can_modblock']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_auth']; ?></p>
						<select id="set_can_auth">
							<?php echo listRankStaff($setting['can_auth']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_verify']; ?></p>
						<select id="set_can_verify">
							<?php echo listRankStaff($setting['can_verify']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_note']; ?></p>
						<select id="set_can_note">
							<?php echo listRankStaff($setting['can_note']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminStaffPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="staff_security" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_vghost']; ?></p>
						<select id="set_can_vghost">
							<?php echo listRankStaffExtend($setting['can_vghost']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_vip']; ?></p>
						<select id="set_can_vip">
							<?php echo listRankStaff($setting['can_vip']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_vemail']; ?></p>
						<select id="set_can_vemail">
							<?php echo listRankStaff($setting['can_vemail']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_vname']; ?></p>
						<select id="set_can_vname">
							<?php echo listRankStaff($setting['can_vname']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_vhistory']; ?></p>
						<select id="set_can_vhistory">
							<?php echo listRankStaff($setting['can_vhistory']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_vwallet']; ?></p>
						<select id="set_can_vwallet">
							<?php echo listRankStaff($setting['can_vwallet']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_vother']; ?></p>
						<select id="set_can_vother">
							<?php echo listRankStaff($setting['can_vother']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminStaffPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="staff_system" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_news']; ?></p>
						<select id="set_can_news">
							<?php echo listRankSuper($setting['can_news']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_mcontact']; ?></p>
						<select id="set_can_mcontact">
							<?php echo listRankSuper($setting['can_mcontact']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_mip']; ?></p>
						<select id="set_can_mip">
							<?php echo listRankSuper($setting['can_mip']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_mplay']; ?></p>
						<select id="set_can_mplay">
							<?php echo listRankSuper($setting['can_mplay']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_mlogs']; ?></p>
						<select id="set_can_mlogs">
							<?php echo listRankSuper($setting['can_mlogs']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_mroom']; ?></p>
						<select id="set_can_mroom">
							<?php echo listRankSuper($setting['can_mroom']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_mfilter']; ?></p>
						<select id="set_can_mfilter">
							<?php echo listRankSuper($setting['can_mfilter']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_maddons']; ?></p>
						<select id="set_can_maddons">
							<?php echo listRankSuper($setting['can_maddons']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_dj']; ?></p>
						<select id="set_can_dj">
							<?php echo listRankSuper($setting['can_dj']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_cuser']; ?></p>
						<select id="set_can_cuser">
							<?php echo listRankStaff($setting['can_cuser']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminStaffPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
			<div id="staff_other" class="hide_zone tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_inv']; ?></p>
						<select id="set_can_inv">
							<?php echo listRankStaff($setting['can_inv']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_content']; ?></p>
						<select id="set_can_content">
							<?php echo listRankStaff($setting['can_content']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_topic']; ?></p>
						<select id="set_can_topic">
							<?php echo listRankStaff($setting['can_topic']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_clear']; ?></p>
						<select id="set_can_clear">
							<?php echo listRankStaff($setting['can_clear']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_rpass']; ?></p>
						<select id="set_can_rpass">
							<?php echo listRankStaff($setting['can_rpass']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_bpriv']; ?></p>
						<select id="set_can_bpriv">
							<?php echo listRankStaff($setting['can_bpriv']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminStaffPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>