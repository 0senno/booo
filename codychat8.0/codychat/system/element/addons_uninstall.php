<div class="sub_list_item blisting addons_item btauto">
	<div class="sub_list_avatar">
		<img class="lazy" data-src="addons/<?php echo $boom['addons']; ?>/files/icon.png" src="<?php echo imgLoader(); ?>"/>
	</div>
	<div class="sub_list_name addons_name">
		<?php echo boomUnderClear($boom['addons']); ?>
	</div>
	<div class="sub_list_cell bcauto">
		<button class="default_btn button work_button"><i class="fa fa-clock-o"></i> Uninstalling...</button>
		<button onclick="configAddons('<?php echo $boom['addons']; ?>');" type="button" class="config_addons button default_btn"><i class="fa fa-cogs edit_btn"></i> <span class="hide_mobile"><?php echo $lang['settings']; ?></span></button>
		<?php if(boomAllow(100)){ ?>
		<button onclick="removeAddons(this, '<?php echo $boom['addons']; ?>');" class="button delete_btn"><i class="fa fa-trash-can edit_btn"></i> <span class="hide_mobile"><?php echo $lang['uninstall']; ?></span></button>
		<?php } ?>
	</div>
</div>