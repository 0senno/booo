<?php
require(__DIR__ . '/../../config_admin.php');

if(!canManageAddons()){
	die();
}
?>
<?php echo elementTitle($lang['manage_addons']); ?>
<div class="page_full">
	<div class="page_element">
		<div id="addons_list">
		<?php echo adminAddonsList(); ?>
		</div>
	</div>
</div>