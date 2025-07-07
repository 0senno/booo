<?php
require(__DIR__ . '/../../config_admin.php');

if(!boomAllow(min($setting['can_kick'], $setting['can_ghost'], $setting['can_mute'], $setting['can_ban']))){
	die();
}
?>
<?php echo elementTitle($lang['manage_action']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="setting_element ">
			<p class="label"><?php echo $lang['search']; ?></p>
			<select id="member_action">
				<option value="1000" selected disabled><?php echo $lang['select']; ?></option>
				<?php if(canMute()){ ?>
				<option value="muted"><?php echo $lang['muted']; ?></option>
				<option value="mmuted"><?php echo $lang['main_muted']; ?></option>
				<option value="pmuted"><?php echo $lang['private_muted']; ?></option>
				<?php } ?>
				<?php if(canKick()){ ?>
				<option value="kicked"><?php echo $lang['kicked']; ?></option>
				<?php } ?>
				<?php if(canGhost()){ ?>
				<option value="ghosted"><?php echo $lang['ghosted']; ?></option>
				<?php } ?>
				<?php if(canBan()){ ?>
				<option value="banned"><?php echo $lang['banned']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="page_full">
		<div id="action_listing" class="page_element">
			<?php echo emptyZone($lang['empty']); ?>
		</div>
	</div>
</div>