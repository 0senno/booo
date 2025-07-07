<?php
require(__DIR__ . '/../../config_admin.php');

if(!canManageDj()){
	die();
}
?>
<?php echo elementTitle($lang['manage_dj']); ?>
<div class="page_full">
	<div class="page_element">
		<div class="form_content">
			<div class="setting_element ">
				<p class="label"><?php echo $lang['username']; ?></p>
				<input id="dj_name" class="full_input">
			</div>
		</div>
		<div class="form_control">
			<button type="button" onclick="addDj();" class="reg_button theme_btn"><i class="fa fa-plus-circle"></i> <?php echo $lang['add']; ?></button>
		</div>
	</div>
	<div class="page_full">
		<div id="dj_listing" class="page_element">
				<?php echo listDj(); ?>
		</div>
	</div>
</div>