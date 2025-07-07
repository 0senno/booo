<?php
require(__DIR__ . '/../../config_admin.php');

if(!canManagePlayer()){
	die();
}
?>
<?php echo elementTitle($lang['manage_player']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['default_stream']; ?></p>
				<select id="set_default_player">
					<?php echo adminPlayer($setting['player_id'], 2); ?>
				</select>
			</div>
		</div>
		<div class="form_control">
			<button onclick="saveAdminPlayer();"  type="button" class="reg_button theme_btn"><?php echo $lang['save']; ?></button>
			<button type="button" onclick="openAddPlayer();" class="reg_button default_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add_player_stream']; ?></button>
		</div>
	</div>
	<div class="page_element">
		<div id="admiN_stream_list">
			<?php echo listStreamPlayer(); ?>
		</div>
	</div>
</div>