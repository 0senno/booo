<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(100)){
	die();
}
?>
<?php echo elementTitle($lang['room_permission']); ?>
<div class="page_full">

	<div>		
		<div class="tab_menu">
			<ul>
				<li class="tab_menu_item tab_selected" data="staffperm" data-z="staff_act"><?php echo $lang['action']; ?></li>
			</ul>
		</div>
	</div>
	<div class="page_element">
		<div id="staffperm">
			<div id="staff_act" class="tab_zone">
				<div class="form_content">
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_rlogs']; ?></p>
						<select id="set_can_rlogs">
							<?php echo listRoomStaffRank($setting['can_rlogs']); ?>
						</select>
					</div>
					<div class="setting_element">
						<p class="label"><?php echo $lang['can_clear']; ?></p>
						<select id="set_can_rclear">
							<?php echo listRoomStaffRank($setting['can_rclear']); ?>
						</select>
					</div>
				</div>
				<div class="form_control">
					<button onclick="saveAdminRoomPermission();" type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
				</div>
			</div>
		</div>
	</div>
</div>